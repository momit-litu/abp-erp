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
    public function revise_requests(){
        return $this->hasMany('App\Models\StudentRevisePayment','student_enrollment_id','id');
    }
    public function student(){
        return $this->hasOne('App\Models\Student','id','student_id');
    }
    public function batch(){
        return $this->hasOne('App\Models\Batch','id','batch_id');
    }
    public function batch_fee(){
        return $this->hasOne('App\Models\BatchFee','id','batch_fees_id');
      }

    public function getBatchesByStudentId($studentId)
    {
        $studentsCourses = $this->with('batch')->with('batch.course')->where('student_id', $studentId)
                ->orderBy('created_at','desc')
                ->get();

        $return_arr = array();
        foreach($studentsCourses as $studentsCourse){        
            $data['batch_name'] = $studentsCourse->batch->batch_name; 
            $data['course_name']= $studentsCourse->batch->course->title;
            $data['start_date'] = $studentsCourse->batch->start_date; 
            $data['end_date']   = ($studentsCourse->batch->end_date ==null)?"":$studentsCourse->batch->end_date;
            $data['total_credit_hour']  =  $studentsCourse->batch->course->total_credit_hour;
            $data['semester_no']=  $studentsCourse->batch->course->semester_no;

            $data['running_status'] 	= "";
            if($studentsCourse->batch->running_status == 'Completed')
                $data['running_status'] 	= "<button class='btn btn-xs btn-primary' disabled>Completed</button>";
            else if($studentsCourse->batch->running_status == 'Running')    
                $data['running_status'] 	= "<button class='btn btn-xs btn-success' disabled>Running</button>";
            else if($studentsCourse->batch->running_status == 'Upcoming')    
                $data['running_status'] 	=  "<button class='btn btn-xs btn-info' disabled>Upcoming</button>";
            $return_arr[] = $data;
        }
        return  (object) $return_arr;
    }
}
