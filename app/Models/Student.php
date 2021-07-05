<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email',  'contact_no','emergency_contact',  'address','date_of_birth','nid_no','user_profile_image','remarks','status','study_mode','type','current_emplyment','last_qualification','how_know','last_qualification_other','passing_year'
    ];

	public function documents(){
		return $this->hasMany('App\Models\StudentDocument','id','student_id');
	}
}
