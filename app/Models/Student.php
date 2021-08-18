<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'student_no', 'contact_no','emergency_contact',  'address','date_of_birth','nid_no','user_profile_image','remarks','status','study_mode','type','register_type','registration_completed','current_emplyment','last_qualification','how_know','passing_year'
    ];

	public function documents(){
		return $this->hasMany('App\Models\StudentDocument','student_id','id');
	}
    public function user(){
		return $this->hasOne('App\Models\User','student_id','id');
	}
	public function centers(){
		return $this->belongsToMany('App\Models\Batch','batch_students');	
	}
	public function batches(){
		return $this->belongsToMany('App\Models\Batch','batch_students')->withPivot('id','total_payable', 'total_paid', 'status');
	}
}
