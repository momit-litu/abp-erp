<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchFee extends Model
{
    protected $fillable= [
        'id',  'batch_id', 'plan_name', 'installment_duration','total_installment', 'payable_amount',  'payment_type',  'status'
    ];
    public function batch(){
		return $this->hasOne('App\Models\Batch','id','batch_id');
	}
    public function installments(){
		return $this->hasMany('App\Models\BatchFeesDetail','batch_fees_id','id');
	}
}
