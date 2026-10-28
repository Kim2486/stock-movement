<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::select([
            'id', 'sku', 'name', 'category', 'borrow_type', 'status', 'quantity', 'sub_quantity'
        ])
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        })
        ->orderBy('sku', 'desc')
        ->get();

        return view('products.index', compact('products', 'search'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'sku'          => 'required|unique:products,sku,' . $id,
            'name'         => 'required|string|max:255',
            'category'     => 'nullable|string',
            'borrow_type'  => 'nullable|string',
            'status'       => 'nullable|string',
            'quantity'     => 'required|integer|min:0',
            'sub_quantity' => 'nullable|integer|min:0',
            'price'        => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect('/products')->with('success', 'แก้ไขข้อมูลอุปกรณ์สำเร็จ!');
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return redirect('/products')->with('success', 'ลบอุปกรณ์ออกจากระบบสำเร็จ!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            Product::whereIn('id', $ids)->delete();
            return redirect('/products')->with('success', 'ลบรายการที่เลือกสำเร็จเรียบร้อย!');
        }

        return redirect('/products')->with('error', 'กรุณาเลือกรายการที่ต้องการลบอย่างน้อย 1 รายการ');
    }

    public function syncFromKintone()
    {
        $domain = env('KINTONE_DOMAIN', '7ersw3iru52g.kintone.com');
        $token  = env('KINTONE_STOCK_API_TOKEN', env('KINTONE_API_TOKEN', 'aTfhOvApzI6MIqwHwxRONxd5xCKnDcuplQ9ZGhOJ'));
        $appId  = env('KINTONE_STOCK_APP_ID', env('KINTONE_APP_ID', 8));

        $response = Http::timeout(20)->withHeaders([
            'X-Cybozu-API-Token' => $token,
        ])->get("https://{$domain}/k/v1/records.json", [
            'app' => $appId,
        ]);

        if ($response->successful()) {
            $records = $response->json()['records'] ?? [];
            $upsertData = [];
            $now = now();

            foreach ($records as $record) {
                // 👈 อัปเดต Field Code ใหม่ทั้งหมดของ App 8
                $category = $record['product_type']['value'] ?? '-';
                if (is_array($category)) {
                    $category = implode(', ', $category);
                }

                $borrowType = $record['product_borrow_type']['value'] ?? '-';
                if (is_array($borrowType)) {
                    $borrowType = implode(', ', $borrowType);
                }

                $status = $record['product_status']['value'] ?? '-';
                if (is_array($status)) {
                    $status = implode(', ', $status);
                }

                $sku = $record['product_code']['value'] ?? null;
                if (!$sku) continue;

                $upsertData[] = [
                    'sku'          => $sku,
                    'name'         => $record['product_name']['value'] ?? 'ไม่ระบุชื่อ',
                    'category'     => $category,
                    'borrow_type'  => $borrowType,
                    'status'       => $status,
                    'quantity'     => (int)($record['product_qty_main']['value'] ?? 0),
                    'sub_quantity' => (int)($record['product_qty_sub']['value'] ?? 0),
                    'description'  => $record['product_description']['value'] ?? '',
                    'price'        => 0.00,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }

            if (!empty($upsertData)) {
                Product::upsert(
                    $upsertData,
                    ['sku'],
                    ['name', 'category', 'borrow_type', 'status', 'quantity', 'sub_quantity', 'description', 'price', 'updated_at']
                );
            }

            return redirect('/products')->with('success', 'ซิงค์ข้อมูลจาก Kintone ครบถ้วนเรียบร้อย!');
        }

        return redirect('/products')->with('error', 'ไม่สามารถเชื่อมต่อกับ Kintone Stock App ได้');
    }
}