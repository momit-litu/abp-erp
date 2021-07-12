<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable= [
        'id', 'course_id', 'batch_name', 'details','start_date', 'end_date',  'running_status', 'fees',  'discounted_fees', 'student_limit', 'total_enrolled_student', 'status'
    ];

    public function course(){
      return $this->hasOne('App\Models\Course','id','course_id');
    }
    public function batch_fees(){
      return $this->hasMany('App\Models\BatchFee','batch_id','id');
    }
    public function students(){
      return $this->belongsToMany('App\Models\Student','batch_students')->withPivot('id','total_payable', 'total_paid', 'status');
    }
}
