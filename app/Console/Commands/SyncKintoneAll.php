<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\EmployeeController; // 🟢 1. นำเข้า EmployeeController

#[Signature('kintone:sync-all')]
#[Description('Automated Background Sync for Kintone Stock, History, and Employee Data')]
class SyncKintoneAll extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('⚡ Starting Kintone Sync...');

        // 1. ซิงค์ข้อมูลสต็อกอุปกรณ์ (App ID 8)
        try {
            app(ProductController::class)->syncFromKintone();
            $this->info('✅ Stock synced successfully.');
        } catch (\Exception $e) {
            $this->error('❌ Stock Sync Error: ' . $e->getMessage());
        }

        // 2. ซิงค์ข้อมูลประวัติการเบิก-คืน (App ID 12)
        try {
            app(HistoryController::class)->syncFromKintone();
            $this->info('✅ History synced successfully.');
        } catch (\Exception $e) {
            $this->error('❌ History Sync Error: ' . $e->getMessage());
        }

        // 3. 🟢 ซิงค์ข้อมูลฐานข้อมูลพนักงาน (App ID 9)
        try {
            app(EmployeeController::class)->syncFromKintone();
            $this->info('✅ Employees synced successfully.');
        } catch (\Exception $e) {
            $this->error('❌ Employee Sync Error: ' . $e->getMessage());
        }

        $this->info('🎉 All Kintone Data Synced Successfully!');
    }
}