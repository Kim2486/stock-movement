<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrow_history_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_history_id')->constrained('borrow_histories')->onDelete('cascade');
            $table->integer('seq')->nullable(); // ลำดับ (sub_seq)
            $table->string('sub_ref_doc')->nullable(); // เลขที่อ้างอิงย่อย REQ/RET (sub_ref_doc)
            $table->string('product_code')->nullable(); // รหัสอุปกรณ์ (sub_equipment_id)
            $table->string('product_name')->nullable(); // ชื่ออุปกรณ์ (sub_equipment_name)
            $table->string('branch')->nullable(); // สาขา (sub_branch)
            $table->string('request_type')->nullable(); // ประเภทรายการ เช่น เบิกอุปกรณ์/คืนอุปกรณ์ (sub_movement_type)
            $table->string('return_due_date')->nullable(); // กำหนดวันคืน (sub_due_date)
            $table->string('category')->nullable(); // ประเภทอุปกรณ์ (sub_device_type)
            $table->string('borrow_type')->nullable(); // ประเภทการเบิก (sub_borrow_type)
            $table->string('status')->nullable(); // สถานะอุปกรณ์ (sub_item_status)
            $table->string('quantity')->default('0'); // จำนวน (sub_qty)
            $table->string('remaining_quantity')->default('0'); // เหลือต้องคืน (sub_calculated_rem)
            $table->string('returned_quantity')->default('0'); // จำนวนที่คืนแล้วสะสม (sub_returned_accum)
            $table->text('description')->nullable(); // คำอธิบาย/หมายเหตุ (sub_log_remark)
            $table->string('actual_returner')->nullable(); // ผู้ที่มาคืน (sub_actual_returner)
            $table->string('received_by')->nullable(); // ผู้รับคืน (sub_received_by)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_history_items');
    }
};