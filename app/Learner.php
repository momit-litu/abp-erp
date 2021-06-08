<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    protected $fillable = [
        'center_id','first_name', 'last_name', 'email', 'contact_no', 'address','date_of_birth','nid_no','user_profile_image','remarks','status'
    ];
	
	public function center(){
		return $this->belongsTo('App\Center');	
	}
	
	public function registrations(){
		return $this->belongsToMany('App\Learner','registration_learners')->withPivot('id','pass_status', 'certificate_no', 'is_printd');
	}
}
