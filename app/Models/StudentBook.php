<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class StudentBook extends Model
{
    protected $fillable= [
        'id',  'batch_book_id','batch_student_id', 'student_id', 'sent_date','received_date','status'
    ,'received_date'];
	
	public function feedbacks(){
      return $this->hasMany('App\Models\StudentBooksFeedback','id','student_book_id');
    }
	public function student(){
		return $this->hasOne('App\Models\Student','id','student_id');
	}
	public function book(){
		return $this->hasOne('App\Models\BatchBook','id','batch_book_id');
	}
	public function batchStudent(){
		return $this->hasOne('App\Models\BatchStudent','id','batch_student_id');
	}
}
