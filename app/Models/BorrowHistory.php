<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowHistory extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(BorrowHistoryItem::class);
    }
}