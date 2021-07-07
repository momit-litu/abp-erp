<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable= [
        'id', 'course_id', 'batch_name', 'details','start_date', 'end_date',  'running_status', 'fees',  'student_limit', 'total_enrolled_student', 'status'
    ];

    public function course(){
		return $this->hasOne('App\Models\Course','id','course_id');
	}
    public function fees(){
		return $this->hasMany('App\Models\batchFee','batch_id','id');
	}
}
