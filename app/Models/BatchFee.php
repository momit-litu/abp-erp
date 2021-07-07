<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchFee extends Model
{
    protected $fillable= [
        'id', 'course_id', 'batch_id', 'installment_duration','total_installment', 'amount',  'payment_type', 'fees',  'status'
    ];

    public function batch(){
		return $this->hasOne('App\Models\Batch','batch_id','id');
	}
}
