<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    protected $fillable= [
        'id','student_enrollment_id', 'batch_id', 'student_id','batch_fees_id','total_payable','total_paid','balance','status','prev_batch_student_id','current_batch', 'result_published_status', 'transfer_fee','transfer_date','remarks', 'result_published_date','certificate_no'
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
    public function prev_batch(){
        return $this->hasOne('App\Models\BatchStudent','id','prev_batch_student_id');
    }
    public function batch_fee(){
        return $this->hasOne('App\Models\BatchFee','id','batch_fees_id');
    }
    public function batch_student_units(){
        return $this->hasMany('App\Models\BatchStudentUnit','batch_student_id','id');
    }
    public function getBatchesByStudentId($studentId)
    {
        $studentsCourses = $this->with('batch','prev_batch','batch.course')
                ->where('student_id', $studentId)
                ->where('current_batch', 'Yes')
                ->orderBy('created_at','desc')
                ->get();

        $return_arr = array();
        foreach($studentsCourses as $studentsCourse){     
            if($studentsCourse->prev_batch_student_id){
                $data['batch_name'] = $studentsCourse->batch->batch_name.' <span class="text-danger">(Trasfered from '.$studentsCourse->prev_batch->batch->batch_name.')</span>';
            }
            else 
                $data['batch_name'] = $studentsCourse->batch->batch_name; 

            $data['course_name']= $studentsCourse->batch->course->title;
            $data['student_enrollment_id']= $studentsCourse->student_enrollment_id;       
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
    public function certificate_status(){
        return $this->hasOne('App\Models\CertificateState','id','certificate_status');
    }	
    public function batch_student_feedback(){
        return $this->hasMany('App\Models\CertificateFeedback','batch_student_id','id');
    }
}
