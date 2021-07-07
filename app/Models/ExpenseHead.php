<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseHead extends Model
{
    protected $fillable = [
        'expense_head_name',  'expense_category_id', 'status'
    ];

    public function expensecategory()
    {
        return $this->belongsTo(ExpneseCategory::class, 'expense_category_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(Expnese::class, 'expense_head_id', 'id');
    }
}
