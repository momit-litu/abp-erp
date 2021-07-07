<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_head_id', 'amount', 'details', 'attachment', 'payment_status', 'status'
    ];

    public function expenseHead(){
        return $this->belongsTo(ExpenseHead::class, 'expense_head_id', 'id');
    }
}
