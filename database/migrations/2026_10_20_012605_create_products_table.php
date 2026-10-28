<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // ชื่อสินค้า
            $table->string('sku')->unique();              // รหัส SKU
            $table->string('category')->nullable();       // ประเภทอุปกรณ์
            $table->string('borrow_type')->nullable();    // ประเภทการเบิก
            $table->string('status')->nullable();         // สถานะอุปกรณ์
            $table->integer('quantity')->default(0);      // จำนวน (สาขาหลัก)
            $table->integer('sub_quantity')->default(0);  // จำนวน (สาขาย่อย)
            $table->text('description')->nullable();      // คำอธิบาย
            $table->decimal('price', 10, 2)->default(0);  // ราคา
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};