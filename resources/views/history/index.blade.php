<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการเบิก-คืน อุปกรณ์</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="container mx-auto px-4 py-10 max-w-7xl">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">📋 ประวัติการเบิก-คืน</h1>
                <p class="text-sm text-gray-500 mt-1">ตรวจสอบประวัติการเบิกถอนอุปกรณ์ สถานะการอนุมัติ และรายการยืม-คืนจาก Kintone และ AWS RDS</p>
            </div>
            <!-- ปุ่ม Action ฝั่งขวาบน -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="/" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-300 text-slate-800 hover:bg-slate-800 hover:text-white text-sm font-medium rounded-xl shadow-sm hover:shadow-slate-200 transition-all duration-200 group">
                    <span class="mr-2 text-base group-hover:scale-110 transition-transform">🏠</span>
                    <span>หน้าหลัก</span>
                </a>
                <a href="/history/sync-kintone" id="sync-btn" onclick="handleSync(this)" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow-emerald-200 transition-all duration-200">
                    <span id="sync-icon" class="mr-1.5 text-base">🔄</span>
                    <span id="sync-text">ซิงค์ประวัติ</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg shadow-sm text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-lg shadow-sm text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <form action="/history" method="GET" class="flex w-full md:max-w-md">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ค้นหาเลขที่เอกสาร, ชื่อผู้เบิก, หรือแผนก..." class="w-full px-4 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-r-lg transition min-w-[90px]">ค้นหา</button>
            </form>
            @if(isset($search) && $search != '')
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">ผลการค้นหา: "{{ $search }}"</span>
                    <a href="/history" class="text-sm text-indigo-600 hover:underline">ล้างการค้นหา</a>
                </div>
            @endif
        </div>

        @if(isset($histories) && count($histories) > 0)
        <!-- แถบเครื่องมือจัดการ Bulk Delete -->
        <div class="flex flex-wrap justify-between items-center mb-4 gap-4 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-2 py-1">
                    <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500 w-4 h-4 cursor-pointer">
                    <label for="select-all" class="text-sm font-medium text-gray-700 cursor-pointer select-none">เลือกทั้งหมด</label>
                </div>
                
                <form action="/history/bulk-delete" method="POST" id="bulk-delete-form" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบรายการประวัติที่เลือกทั้งหมด?');" class="inline">
                    @csrf
                    <!-- ปุ่มลบปรับให้ disabled ไว้ล่วงหน้าหากยังไม่เลือกรายการ -->
                    <button type="submit" id="bulk-delete-btn" disabled class="inline-flex items-center px-3.5 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                        <span class="mr-1.5">🗑️</span>
                        <span>ลบรายการที่เลือก (<span id="selected-count">0</span>)</span>
                    </button>
                </form>
            </div>
            <div class="text-xs text-gray-500 px-2">
                ทั้งหมด {{ count($histories) }} รายการ
            </div>
        </div>
        @endif

        <!-- Cards List -->
        <div class="space-y-5">
            @forelse($histories as $history)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow transition duration-200">
                <!-- Header Card (เลขอ้างอิงหลักโดดเด่นด้วยสี Indigo) -->
                <div class="bg-gray-50 px-5 py-3.5 border-b border-gray-200 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="ids[]" value="{{ $history->id }}" form="bulk-delete-form" onchange="updateSelectedCount()" class="item-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                        <span class="text-base font-semibold text-indigo-600 tracking-tight">{{ $history->reference_no }}</span>
                        <span class="text-xs text-gray-500 font-normal">📅 {{ $history->request_date }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-medium {{ $history->approval_status == 'อนุมัติ' || $history->approval_status == 'อนุมัติแล้ว' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                            {{ $history->approval_status }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-medium {{ $history->return_status == 'คืนครบแล้ว' || $history->return_status == 'คืนครบถ้วน' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                            {{ $history->return_status }}
                        </span>

                        <form action="/history/{{ $history->id }}" method="POST" onsubmit="return confirm('คุณต้องการลบประวัติเลขที่เอกสาร {{ $history->reference_no }} นี้ใช่หรือไม่?');" class="inline ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded transition" title="ลบรายการนี้">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Requester Info (แสดงแผนกเป็นตัวหนังสือธรรมดา) -->
                <div class="px-5 py-3 bg-white border-b border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-3 text-xs text-gray-600">
                    <div><span class="text-gray-500">ผู้เบิก:</span> <span class="text-gray-800 font-normal">{{ $history->requester_name }}</span></div>
                    <div><span class="text-gray-500">รหัสพนักงาน:</span> <span class="text-gray-800 font-mono font-normal">{{ $history->employee_id }}</span></div>
                    <div><span class="text-gray-500">แผนก:</span> <span class="text-gray-800 font-normal">{{ $history->department }}</span></div>
                    <div><span class="text-gray-500">วัตถุประสงค์:</span> <span class="text-gray-800 font-normal">{{ $history->purpose }}</span></div>
                </div>

                <!-- Items Subtable -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-xs text-left">
                        <thead class="bg-gray-50/70 text-gray-500 font-semibold text-[11px]">
                            <tr>
                                <th class="px-4 py-2.5">เลขที่อ้างอิง</th>
                                <th class="px-3 py-2.5">รหัสอุปกรณ์</th>
                                <th class="px-4 py-2.5">ชื่ออุปกรณ์</th>
                                <th class="px-3 py-2.5">สาขา</th>
                                <th class="px-3 py-2.5 text-center">ประเภทรายการ</th>
                                <th class="px-3 py-2.5 text-center">กำหนดคืน</th>
                                <th class="px-3 py-2.5 text-center">จำนวน</th>
                                <th class="px-3 py-2.5 text-center">เหลือต้องคืน</th>
                                <th class="px-3 py-2.5 text-center">คืนแล้วสะสม</th>
                                <th class="px-4 py-2.5">คำอธิบาย</th>
                                <th class="px-3 py-2.5">ผู้ที่มาคืน</th>
                                <th class="px-3 py-2.5">ผู้รับคืน</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                            @foreach($history->items as $item)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="px-4 py-2.5 font-normal text-slate-700">{{ $item->sub_ref_doc ?? '-' }}</td>
                                <td class="px-3 py-2.5 font-mono text-gray-600 font-normal">{{ $item->product_code }}</td>
                                <td class="px-4 py-2.5 font-normal text-gray-800">{{ $item->product_name }}</td>
                                <td class="px-3 py-2.5 text-gray-600 font-normal">{{ $item->branch }}</td>
                                <td class="px-3 py-2.5 text-center">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-normal {{ $item->request_type == 'เบิกอุปกรณ์' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                                        {{ $item->request_type }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-center text-gray-600 font-normal">{{ $item->return_due_date ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-center font-normal text-gray-800">{{ $item->quantity }}</td>
                                <td class="px-3 py-2.5 text-center font-normal {{ (int)$item->remaining_quantity === 0 || $item->remaining_quantity == '0' || $item->remaining_quantity == 'ไม่ต้องคืน' ? 'text-gray-400' : 'text-rose-600' }}">
                                    {{ $item->remaining_quantity }}
                                </td>
                                <td class="px-3 py-2.5 text-center font-normal text-emerald-600">{{ $item->returned_quantity }}</td>
                                <td class="px-4 py-2.5 text-gray-500 max-w-xs truncate font-normal">{{ $item->description ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-gray-600 font-normal">{{ $item->actual_returner ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-gray-600 font-normal">{{ $item->received_by ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @empty
            <div class="bg-white p-12 text-center text-gray-500 rounded-xl border border-gray-200 shadow-sm text-sm">
                ไม่พบข้อมูลประวัติการเบิก-คืน สามารถกดปุ่ม <a href="/history/sync-kintone" onclick="handleSync(this)" class="text-indigo-600 underline font-medium hover:text-indigo-800">ซิงค์ประวัติ Kintone</a> เพื่อดึงข้อมูลใหม่ได้ทันที
            </div>
            @endforelse
        </div>
    </div>

    <script>
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            const countElement = document.getElementById('selected-count');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

            if (countElement) {
                countElement.textContent = checkedCount;
            }

            // เปิด/ปิด การใช้งานปุ่มลบตามจำนวนที่เลือก
            if (bulkDeleteBtn) {
                if (checkedCount > 0) {
                    bulkDeleteBtn.removeAttribute('disabled');
                } else {
                    bulkDeleteBtn.setAttribute('disabled', 'true');
                }
            }
            
            const allCheckboxes = document.querySelectorAll('.item-checkbox');
            const selectAllCheckbox = document.getElementById('select-all');
            if (selectAllCheckbox && allCheckboxes.length > 0) {
                selectAllCheckbox.checked = checkedCount === allCheckboxes.length;
            }
        }

        function handleSync(btn) {
            btn.classList.add('pointer-events-none', 'opacity-75');
            const icon = btn.querySelector('#sync-icon');
            const text = btn.querySelector('#sync-text');
            if (icon) icon.classList.add('animate-spin');
            if (text) text.textContent = 'กำลังซิงค์ประวัติจาก Kintone...';
        }
    </script>
</body>
</html>