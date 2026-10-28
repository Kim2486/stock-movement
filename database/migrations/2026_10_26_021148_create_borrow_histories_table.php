<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrow_histories', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique(); // Field Code: log_ref_doc
            $table->string('request_date')->nullable(); // Field Code: log_datetime
            $table->string('requester_name')->nullable(); // Field Code: log_operator
            $table->string('employee_id')->nullable(); // Field Code: log_emp_id
            $table->string('phone')->nullable(); // Field Code: log_phone
            $table->string('department')->nullable(); // Field Code: log_department
            $table->string('approval_status')->default('รออนุมัติ'); // Field Code: log_approval_status
            $table->string('purpose')->nullable(); // Field Code: log_purpose
            $table->string('return_status')->default('ยังไม่คืน'); // Field Code: Return_Status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_histories');
    }
};