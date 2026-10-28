<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'category',
        'borrow_type',
        'status',
        'quantity',
        'sub_quantity',
        'description',
        'price',
    ];
}