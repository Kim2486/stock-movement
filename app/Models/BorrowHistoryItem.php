<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowHistoryItem extends Model
{
    protected $guarded = [];

    public function history()
    {
        return $this->belongsTo(BorrowHistory::class, 'borrow_history_id');
    }
}