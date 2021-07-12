<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    protected $fillable= [
        'id', 'batch_id', 'student_id','batch_fees_id','total_payable','total_paid','balance','status'
    ];
    public function payments(){
        return $this->hasMany('App\Models\StudentPayment','student_enrollment_id','id');
    }
    public function student(){
        return $this->hasOne('App\Models\Student','id','student_id');
    }
    public function batch(){
        return $this->hasOne('App\Models\Batch','id','batch_id');
      }
}
