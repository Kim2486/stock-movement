<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Portal - ระบบเบิก-คืนอุปกรณ์บริษัท</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800 min-h-screen flex flex-col justify-between items-center">
    
    <div class="w-full max-w-5xl px-6 py-12 my-auto">
        
        <!-- Header Section -->
        <div class="text-center mb-10">
            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm">
                ENTERPRISE PORTAL
            </span>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mt-4 mb-2 flex items-center justify-center gap-3">
                🏢 ระบบเก็บประวัติการเบิก-คืน
            </h1>
            <p class="text-gray-500 text-base font-medium">กรุณาเลือกเมนูระบบที่ต้องการเข้าใช้งาน</p>
        </div>

        <!-- 3 System Cards Grid (กดคลิกได้ทั้งกล่องการ์ด) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1: สต็อกอุปกรณ์ (ครอบทั้งกล่องด้วยแท็ก <a>) -->
            <a href="/products" class="group bg-white rounded-2xl p-7 border border-gray-200 shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all duration-200 flex flex-col justify-between hover:-translate-y-1 block cursor-pointer">
                <div>
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner group-hover:scale-110 transition-transform">
                        📦
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">ระบบจัดการสต็อกอุปกรณ์บริษัท</h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        ดูรายการอุปกรณ์ ตรวจสอบจำนวนสต็อก แก้ไข ลบ และซิงค์ข้อมูลตรงจาก Kintone
                    </p>
                </div>
                <div class="inline-flex items-center text-indigo-600 font-bold text-sm transition pt-2">
                    <span>เข้าใช้งานระบบสต็อก</span>
                    <span class="ml-1.5 group-hover:translate-x-1.5 transition-transform text-base">→</span>
                </div>
            </a>

            <!-- Card 2: ประวัติการเบิก-คืน (ครอบทั้งกล่องด้วยแท็ก <a>) -->
            <a href="/history" class="group bg-white rounded-2xl p-7 border border-gray-200 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-200 flex flex-col justify-between hover:-translate-y-1 block cursor-pointer">
                <div>
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner group-hover:scale-110 transition-transform">
                        📋
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors">ประวัติการเบิก-คืน</h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        ตรวจสอบประวัติการเบิกถอนอุปกรณ์ย้อนหลัง รายการยืม-คืนของพนักงาน และสถานะการอนุมัติ
                    </p>
                </div>
                <div class="inline-flex items-center text-emerald-600 font-bold text-sm transition pt-2">
                    <span>ดูประวัติการเบิก</span>
                    <span class="ml-1.5 group-hover:translate-x-1.5 transition-transform text-base">→</span>
                </div>
            </a>

            <!-- Card 3: ฐานข้อมูลพนักงาน (ครอบทั้งกล่องด้วยแท็ก <a>) -->
            <a href="/employees" class="group bg-white rounded-2xl p-7 border border-gray-200 shadow-sm hover:shadow-lg hover:border-blue-200 transition-all duration-200 flex flex-col justify-between hover:-translate-y-1 block cursor-pointer">
                <div>
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-3xl mb-5 shadow-inner group-hover:scale-110 transition-transform">
                        👤
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">ฐานข้อมูลพนักงาน</h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        ตรวจสอบข้อมูลพนักงาน รหัสพนักงาน แผนก ตำแหน่ง และซิงค์ฐานข้อมูลตรงจาก Kintone
                    </p>
                </div>
                <div class="inline-flex items-center text-blue-600 font-bold text-sm transition pt-2">
                    <span>จัดการข้อมูลพนักงาน</span>
                    <span class="ml-1.5 group-hover:translate-x-1.5 transition-transform text-base">→</span>
                </div>
            </a>

        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-6 text-xs text-gray-400">
        © {{ date('Y') }} Company Stock & Inventory System. Integrated with Kintone & AWS RDS.
    </footer>

</body>
</html>