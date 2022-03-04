<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStudentUnit extends Model
{
    protected $fillable= [
        'id',  'batch_student_id', 'unit_id', 'result','score', 'remarks',  'created_by',  'status'
    ];
   
    public function level(){
      return $this->hasOne('App\Models\Unit','id','unit_id');
    }	
    public function batchStudent(){
		  return $this->hasOne('App\Models\BatchStudent','id','batch_student_id');
    }
    public function result(){
      return $this->hasOne('App\Models\ResultStates','id','result');
    }	
}
