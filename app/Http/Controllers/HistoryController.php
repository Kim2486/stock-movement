<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\BorrowHistory;
use App\Models\BorrowHistoryItem;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $histories = BorrowHistory::with('items')
            ->when($search, function ($query, $search) {
                $query->where('reference_no', 'like', "%{$search}%")
                      ->orWhere('requester_name', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%");
            })
            ->orderBy('reference_no', 'desc')
            ->get();

        return view('history.index', compact('histories', 'search'));
    }

    public function syncFromKintone()
    {
        set_time_limit(300);

        $domain = env('KINTONE_DOMAIN', '7ersw3iru52g.kintone.com');
        $token  = env('KINTONE_HISTORY_API_TOKEN', 'zbyppwMY5MoAzp427kVB5qmH0LiZ0I5LO1Ui9X3D');
        $appId  = env('KINTONE_HISTORY_APP_ID', 12);

        $response = Http::timeout(30)->withHeaders([
            'X-Cybozu-API-Token' => $token,
        ])->get("https://{$domain}/k/v1/records.json", [
            'app' => $appId,
        ]);

        if ($response->successful()) {
            $records = $response->json()['records'] ?? [];

            if (empty($records)) {
                return redirect('/history')->with('success', 'ไม่พบข้อมูลประวัติใน Kintone');
            }

            $now = now()->toDateTimeString();
            $historiesData = [];
            $refNos = [];

            foreach ($records as $record) {
                $refNo = $record['log_ref_doc']['value'] ?? null;
                if (!$refNo) continue;

                $operator = $record['log_operator']['value'] ?? '-';
                if (is_array($operator)) {
                    $operator = $operator[0]['name'] ?? '-';
                }

                $refNos[] = $refNo;
                $historiesData[] = [
                    'reference_no'    => $refNo,
                    'request_date'    => $record['log_datetime']['value'] ?? null,
                    'requester_name'  => $operator,
                    'employee_id'     => $record['borrower_emp_id']['value'] ?? '-', // 👈 อัปเดตใหม่
                    'phone'           => $record['borrower_phone']['value'] ?? '-', // 👈 อัปเดตใหม่
                    'department'      => $record['borrower_dept']['value'] ?? '-', // 👈 อัปเดตใหม่
                    'approval_status' => $record['log_approval_status']['value'] ?? 'รออนุมัติ',
                    'purpose'         => $record['purpose']['value'] ?? '-', // 👈 อัปเดตใหม่
                    'return_status'   => $record['return_status']['value'] ?? 'ยังไม่คืน', // 👈 อัปเดตใหม่
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            DB::transaction(function () use ($historiesData, $refNos, $records, $now) {
                BorrowHistory::upsert(
                    $historiesData,
                    ['reference_no'],
                    ['request_date', 'requester_name', 'employee_id', 'phone', 'department', 'approval_status', 'purpose', 'return_status', 'updated_at']
                );

                $historyMap = BorrowHistory::whereIn('reference_no', $refNos)->pluck('id', 'reference_no');

                BorrowHistoryItem::whereIn('borrow_history_id', $historyMap->values())->delete();

                $itemsData = [];
                foreach ($records as $record) {
                    $refNo = $record['log_ref_doc']['value'] ?? null;
                    if (!$refNo || !isset($historyMap[$refNo])) continue;

                    $historyId = $historyMap[$refNo];
                    $tableItems = $record['log_table']['value'] ?? [];

                    foreach ($tableItems as $item) {
                        $row = $item['value'] ?? [];

                        $actualReturner = $row['sub_actual_returner']['value'] ?? '-';
                        if (is_array($actualReturner)) {
                            $actualReturner = $actualReturner[0]['name'] ?? '-';
                        }

                        $receivedBy = $row['sub_received_by']['value'] ?? '-';
                        if (is_array($receivedBy)) {
                            $receivedBy = $receivedBy[0]['name'] ?? '-';
                        }

                        $itemsData[] = [
                            'borrow_history_id'  => $historyId,
                            'seq'                => $row['sub_seq']['value'] ?? null,
                            'sub_ref_doc'        => $row['sub_ref_doc']['value'] ?? '-',
                            'product_code'       => $row['sub_product_code']['value'] ?? '-', // 👈 อัปเดตใหม่
                            'product_name'       => $row['sub_product_name']['value'] ?? '-', // 👈 อัปเดตใหม่
                            'category'           => $row['sub_device_type']['value'] ?? '-',
                            'branch'             => $row['sub_branch']['value'] ?? '-',
                            'request_type'       => $row['sub_movement_type']['value'] ?? '-',
                            'return_due_date'    => $row['sub_due_date']['value'] ?? null,
                            'borrow_type'        => $row['sub_borrow_type']['value'] ?? '-',
                            'status'             => $row['sub_item_status']['value'] ?? '-',
                            'quantity'           => (string)($row['sub_qty']['value'] ?? '0'),
                            'remaining_quantity' => (string)($row['sub_rem_qty']['value'] ?? '0'), // 👈 อัปเดตใหม่
                            'returned_quantity'  => (string)($row['sub_returned_accum']['value'] ?? '0'),
                            'description'        => $row['sub_remark']['value'] ?? '', // 👈 อัปเดตใหม่
                            'actual_returner'    => $actualReturner,
                            'received_by'        => $receivedBy,
                            'created_at'         => $now,
                            'updated_at'         => $now,
                        ];
                    }
                }

                if (!empty($itemsData)) {
                    foreach (array_chunk($itemsData, 100) as $chunk) {
                        BorrowHistoryItem::insert($chunk);
                    }
                }
            });

            return redirect('/history')->with('success', 'ซิงค์ประวัติการเบิก-คืนจาก Kintone สำเร็จเรียบร้อย!');
        }

        return redirect('/history')->with('error', 'ไม่สามารถเชื่อมต่อกับ Kintone ได้');
    }

    public function destroy($id)
    {
        $history = BorrowHistory::findOrFail($id);
        $history->items()->delete();
        $history->delete();

        return redirect('/history')->with('success', 'ลบประวัติการเบิก-คืนสำเร็จเรียบร้อย!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            BorrowHistoryItem::whereIn('borrow_history_id', $ids)->delete();
            BorrowHistory::whereIn('id', $ids)->delete();

            return redirect('/history')->with('success', 'ลบรายการประวัติที่เลือกสำเร็จเรียบร้อย!');
        }

        return redirect('/history')->with('error', 'กรุณาเลือกรายการที่ต้องการลบอย่างน้อย 1 รายการ');
    }
}