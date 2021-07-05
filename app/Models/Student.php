<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'student_no', 'contact_no','emergency_contact',  'address','date_of_birth','nid_no','user_profile_image','remarks','status','study_mode','type','current_emplyment','last_qualification','how_know','passing_year'
    ];

	public function documents(){
		return $this->hasMany('App\Models\StudentDocument','student_id','id');
	}
    public function user(){
		return $this->hasOne('App\Models\User','student_id','id');
	}
}
