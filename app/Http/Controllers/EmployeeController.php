<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $employees = Employee::when($search, function ($query, $search) {
            return $query->where('employee_id', 'like', "%{$search}%")
                         ->orWhere('name', 'like', "%{$search}%")
                         ->orWhere('user_code', 'like', "%{$search}%")
                         ->orWhere('department', 'like', "%{$search}%");
        })
        ->orderBy('employee_id', 'desc')
        ->get();

        return view('employees.index', compact('employees', 'search'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|unique:employees,employee_id,' . $id,
            'user_code'   => 'nullable|string',
            'name'        => 'required|string|max:255',
            'department'  => 'nullable|string',
            'position'    => 'nullable|string',
            'phone'       => 'nullable|string',
        ]);

        $employee->update($validated);

        return redirect('/employees')->with('success', 'แก้ไขข้อมูลพนักงานสำเร็จ!');
    }

    public function destroy($id)
    {
        Employee::destroy($id);
        return redirect('/employees')->with('success', 'ลบข้อมูลพนักงานสำเร็จ!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids && is_array($ids)) {
            Employee::whereIn('id', $ids)->delete();
            return redirect('/employees')->with('success', 'ลบพนักงานที่เลือกสำเร็จเรียบร้อย!');
        }
        return redirect('/employees')->with('error', 'กรุณาเลือกพนักงานที่ต้องการลบอย่างน้อย 1 รายการ');
    }

    public function syncFromKintone()
    {
        $domain = env('KINTONE_DOMAIN', '7ersw3iru52g.kintone.com');
        $token  = env('KINTONE_EMPLOYEE_API_TOKEN', 'Rb1Q2mnmmE8a9baFarCtR566IDVDVibKbjrNFzc4');
        $appId  = env('KINTONE_EMPLOYEE_APP_ID', 9);

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
                $empId = $record['emp_id']['value'] ?? null;
                if (!$empId) continue;

                $name = $record['emp_account_name']['value'] ?? 'ไม่ระบุชื่อ';
                if (is_array($name)) {
                    $name = $name[0]['name'] ?? 'ไม่ระบุชื่อ';
                }

                $userCode = $record['emp_user_code']['value'] ?? '-';
                if (is_array($userCode)) {
                    $userCode = $userCode[0]['code'] ?? '-';
                }

                $upsertData[] = [
                    'employee_id' => $empId,
                    'user_code'   => $userCode,
                    'name'        => $name,
                    'department'  => $record['emp_department']['value'] ?? '-',
                    'position'    => $record['emp_position']['value'] ?? '-', // 👈 อัปเดต Field Code ใหม่
                    'phone'       => $record['emp_tel']['value'] ?? '-',
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }

            if (!empty($upsertData)) {
                Employee::upsert(
                    $upsertData,
                    ['employee_id'],
                    ['user_code', 'name', 'department', 'position', 'phone', 'updated_at']
                );
            }

            return redirect('/employees')->with('success', 'ซิงค์ข้อมูลพนักงานจาก Kintone สำเร็จเรียบร้อย!');
        }

        return redirect('/employees')->with('error', 'ไม่สามารถเชื่อมต่อกับ Kintone Employee App ได้');
    }
}