<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique(); // รหัสพนักงาน (emp_id)
            $table->string('user_code')->nullable(); // ไอดี login (emp_user_code)
            $table->string('name');                 // ชื่อพนักงาน (emp_account_name)
            $table->string('department')->nullable(); // แผนก (emp_department)
            $table->string('position')->nullable();   // ตำแหน่ง (position)
            $table->string('phone')->nullable();      // เบอร์โทร (emp_tel)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};