<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลอุปกรณ์ - Stock Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-white shadow-md rounded-xl border border-gray-200 p-8 w-full max-w-xl">
            <!-- Header Section (นำปุ่มสลับโหมดออกแล้ว) -->
            <div class="mb-6 border-b border-gray-100 pb-4">
                <h1 class="text-2xl font-bold text-gray-800">✏️ แก้ไขข้อมูลอุปกรณ์</h1>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/products/{{ $product->id }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- รหัสทรัพย์สิน (SKU) -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">รหัสทรัพย์สิน (SKU):</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm" required>
                </div>

                <!-- ชื่ออุปกรณ์ -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">ชื่ออุปกรณ์:</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm" required>
                </div>

                <!-- ประเภทอุปกรณ์ & ประเภทการเบิก -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">ประเภทอุปกรณ์:</label>
                        <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">ประเภทการเบิก:</label>
                        <select name="borrow_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm">
                            <option value="ยืม-คืน" {{ old('borrow_type', $product->borrow_type) == 'ยืม-คืน' ? 'selected' : '' }}>ยืม-คืน</option>
                            <option value="เบิกถาวร" {{ old('borrow_type', $product->borrow_type) == 'เบิกถาวร' ? 'selected' : '' }}>เบิกถาวร</option>
                        </select>
                    </div>
                </div>

                <!-- สถานะอุปกรณ์ -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">สถานะ:</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm">
                        <option value="พร้อมใช้งาน" {{ old('status', $product->status) == 'พร้อมใช้งาน' ? 'selected' : '' }}>พร้อมใช้งาน</option>
                        <option value="ส่งซ่อม" {{ old('status', $product->status) == 'ส่งซ่อม' ? 'selected' : '' }}>ส่งซ่อม</option>
                        <option value="ชำรุด/แทงจำหน่าย" {{ old('status', $product->status) == 'ชำรุด/แทงจำหน่าย' ? 'selected' : '' }}>ชำรุด/แทงจำหน่าย</option>
                    </select>
                </div>

                <!-- จำนวนสาขาหลัก & สาขาย่อย -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">สาขาหลัก (จำนวน):</label>
                        <input type="number" min="0" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">สาขาย่อย (จำนวน):</label>
                        <input type="number" min="0" name="sub_quantity" value="{{ old('sub_quantity', $product->sub_quantity) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-300 text-sm">
                    </div>
                </div>

                <!-- ปุ่มควบคุม -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-6">
                    <a href="/products" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition text-sm font-medium">ย้อนกลับ</a>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-semibold shadow-sm">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>