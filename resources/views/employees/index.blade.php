<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Database - ฐานข้อมูลพนักงาน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="container mx-auto px-4 py-10 max-w-7xl">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">👤 ฐานข้อมูลพนักงานบริษัท</h1>
                <p class="text-sm text-gray-500 mt-1">ดึงข้อมูลโดยตรงจาก Kintone และจัดเก็บข้อมูลบน AWS RDS</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <!-- ปุ่มกลับหน้าหลัก -->
                <a href="/" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-300 text-slate-800 hover:bg-slate-800 hover:text-white text-sm font-medium rounded-xl shadow-sm hover:shadow-slate-200 hover:-translate-y-0.5 transition-all duration-200 group">
                    <span class="mr-2 text-base group-hover:scale-110 transition-transform">🏠</span>
                    <span>หน้าหลัก</span>
                </a>

                <!-- ปุ่มซิงค์ Kintone -->
                <a href="/employees/sync-kintone" id="sync-btn" onclick="handleSyncKintone(this)" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow-emerald-200 hover:-translate-y-0.5 transition-all duration-200">
                    <span id="sync-icon" class="mr-1.5">🔄</span>
                    <span id="sync-text">ซิงค์ข้อมูลพนักงาน</span>
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

        <!-- Toolbar: ช่องค้นหา -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <form action="/employees" method="GET" class="flex w-full md:max-w-md">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ค้นหารหัสพนักงาน, ชื่อ, หรือแผนก..." class="w-full px-4 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-r-lg transition min-w-[90px] text-center">ค้นหา</button>
            </form>
            @if(isset($search) && $search != '')
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">ผลการค้นหา: "{{ $search }}"</span>
                    <a href="/employees" class="text-sm text-indigo-600 hover:underline">ล้างการค้นหา</a>
                </div>
            @endif
        </div>

        <!-- ฟอร์มลบหลายรายการ (ใช้ Relative URL เพื่อความปลอดภัยบน Vercel) -->
        <form action="/employees/bulk-delete" method="POST" id="bulk-delete-form">
            @csrf
            <div id="bulk-delete-inputs"></div>
            
            <div class="mb-4 flex justify-between items-center">
                <button type="button" id="bulk-delete-btn" onclick="confirmBulkDelete()" disabled class="inline-flex items-center px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-lg shadow-sm transition disabled:opacity-40 disabled:cursor-not-allowed">
                    <span id="bulk-delete-text">🗑️ ลบรายการที่เลือก (<span id="selected-count">0</span>)</span>
                </button>
            </div>
        </form>

        <!-- Table Card -->
        <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-700 w-12">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                            </th>
                            <th class="px-5 py-3.5 text-sm font-semibold text-gray-700">รหัสพนักงาน</th>
                            <th class="px-5 py-3.5 text-sm font-semibold text-gray-700">ไอดี LOGIN</th>
                            <th class="px-6 py-3.5 text-sm font-semibold text-gray-700">ชื่อพนักงาน</th>
                            <th class="px-5 py-3.5 text-sm font-semibold text-gray-700">แผนก</th>
                            <th class="px-5 py-3.5 text-sm font-semibold text-gray-700">ตำแหน่ง</th>
                            <th class="px-5 py-3.5 text-sm font-semibold text-gray-700">เบอร์โทรศัพท์</th>
                            <th class="px-6 py-3.5 text-center text-sm font-semibold text-gray-700">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($employees as $employee)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                            <td class="px-4 py-3.5 text-center">
                                <input type="checkbox" value="{{ $employee->id }}" class="employee-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                            </td>
                            <td class="px-5 py-3.5 text-sm font-normal text-gray-700 font-mono">{{ $employee->employee_id }}</td>
                            <td class="px-5 py-3.5 text-sm text-gray-700 font-normal">{{ $employee->user_code }}</td>
                            <td class="px-6 py-3.5 text-sm font-medium text-gray-800">{{ $employee->name }}</td>
                            
                            <!-- แผนก (ใส่สีแยกตามชื่อแผนก) -->
                            <td class="px-5 py-3.5 text-sm">
                                @php
                                    $dept = strtolower(trim($employee->department));
                                    $badgeStyle = 'bg-gray-100 text-gray-700 border-gray-200';
                                    
                                    if ($dept === 'it') {
                                        $badgeStyle = 'bg-sky-50 text-sky-700 border-sky-200 font-medium';
                                    } elseif ($dept === 'hr') {
                                        $badgeStyle = 'bg-purple-50 text-purple-700 border-purple-200 font-medium';
                                    } elseif ($dept === 'mkt') {
                                        $badgeStyle = 'bg-amber-50 text-amber-700 border-amber-200 font-medium';
                                    }
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-xs uppercase border {{ $badgeStyle }}">
                                    {{ $employee->department }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5 text-sm text-gray-700 font-normal">{{ $employee->position }}</td>
                            <td class="px-5 py-3.5 text-sm text-gray-700 font-mono tracking-tight font-normal">{{ $employee->phone }}</td>
                            <td class="px-6 py-3.5 text-center text-sm font-normal">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="/employees/{{ $employee->id }}/edit" class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-xs font-medium transition">
                                        ✏️ แก้ไข
                                    </a>
                                    <form action="/employees/{{ $employee->id }}" method="POST" onsubmit="return confirm('คุณต้องการลบพนักงานรหัส {{ $employee->employee_id }} ใช่หรือไม่?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-xs font-medium transition">
                                            🗑️ ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                                ไม่พบข้อมูลพนักงานในระบบ สามารถกดปุ่ม <a href="/employees/sync-kintone" onclick="handleSyncKintone(this)" class="text-indigo-600 underline font-medium">ซิงค์ข้อมูลพนักงาน Kintone</a> เพื่อดึงข้อมูลใหม่ได้ทันที
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript ควบคุม -->
    <script>
        const selectAllCheckbox = document.getElementById('select-all');
        const employeeCheckboxes = document.querySelectorAll('.employee-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const selectedCountSpan = document.getElementById('selected-count');

        function updateBulkDeleteState() {
            const checkedCount = document.querySelectorAll('.employee-checkbox:checked').length;
            if (selectedCountSpan) selectedCountSpan.textContent = checkedCount;
            if (bulkDeleteBtn) {
                if (checkedCount > 0) {
                    bulkDeleteBtn.removeAttribute('disabled');
                } else {
                    bulkDeleteBtn.setAttribute('disabled', 'true');
                }
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                employeeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteState();
            });
        }

        employeeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkDeleteState();
                if (selectAllCheckbox) {
                    const allChecked = document.querySelectorAll('.employee-checkbox:checked').length === employeeCheckboxes.length;
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        function handleSyncKintone(element) {
            element.classList.add('pointer-events-none', 'opacity-75');
            const icon = element.querySelector('#sync-icon');
            const text = element.querySelector('#sync-text');
            if (icon) icon.classList.add('animate-spin');
            if (text) text.textContent = 'กำลังซิงค์ข้อมูลพนักงานจาก Kintone...';
        }

        function confirmBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.employee-checkbox:checked');
            if (checkedBoxes.length === 0) return;

            if (!confirm(`คุณต้องการลบรายชื่อพนักงานที่เลือกทั้งหมด (${checkedBoxes.length} รายการ) ใช่หรือไม่?`)) return;

            const container = document.getElementById('bulk-delete-inputs');
            container.innerHTML = '';

            checkedBoxes.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });

            document.getElementById('bulk-delete-form').submit();
        }
    </script>
</body>
</html>