<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\EmployeeController;

// 1. หน้าทางเข้าหลัก (Portal Page)
Route::get('/', function () {
    return view('home');
});

// 2. เส้นทางสำหรับการซิงค์ข้อมูลสต็อกสินค้าจาก Kintone
Route::get('/sync-kintone', [ProductController::class, 'syncFromKintone']);

// 3. เส้นทางสำหรับลบสินค้าหลายรายการพร้อมกัน (วางไว้ก่อน Route ที่มี {id} เพื่อป้องกันข้อผิดพลาด)
Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete']);

// 4. เส้นทางระบบจัดการสต็อกสินค้า (เฉพาะดูรายการ แก้ไข และลบ)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// 5. เส้นทางสำหรับระบบประวัติการเบิก - ยืม - คืน (ใช้งานผ่าน HistoryController)
Route::get('/history', [HistoryController::class, 'index']);
Route::get('/history/sync-kintone', [HistoryController::class, 'syncFromKintone']);

// 🛠️ Route สำหรับลบประวัติ (วาง bulk-delete ไว้ก่อน {id} เสมอ)
Route::post('/history/bulk-delete', [HistoryController::class, 'bulkDelete']);
Route::delete('/history/{id}', [HistoryController::class, 'destroy']);

// 6. เส้นทางสำหรับฐานข้อมูลพนักงาน (Employee Database)
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/sync-kintone', [EmployeeController::class, 'syncFromKintone']);
Route::post('/employees/bulk-delete', [EmployeeController::class, 'bulkDelete']);
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

// 7. ระบบแดชบอร์ดและสิทธิ์การใช้งาน
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

// 8. ไฟล์ตั้งค่าระบบ (วางไว้ล่างสุดเสมอ)
require __DIR__.'/settings.php';