<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $fillable= [
        'id', 'student_enrollment_id', 'installment_no','payable_amount','paid_amount', 'payment_status',  'paid_type', 'last_payment_date',  'paid_date', 'payment_refference_no', 'receive_status',  'attachment', 'status'
    ];

    public function enrollment(){
      return $this->hasOne('App\Models\BatchStudent','id','student_enrollment_id');
    }
   /* public function students(){
      return $this->hasOne('App\Models\Student');	
    }*/
}
