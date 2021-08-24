<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class StudentRevisePayment extends Model
{
    protected $fillable= [
        'id', 'student_enrollment_id', 'revise_details','revise_status'
    ];

    public function enrollment(){
        return $this->hasOne('App\Models\BatchStudent','id','student_enrollment_id');
    }
    

}
