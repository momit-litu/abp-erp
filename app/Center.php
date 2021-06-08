<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
     protected $fillable = [
        'code', 'name', 'short_name', 'website','address', 'proprietor_name',  'mobile_no', 'liaison_office','liaison_office_address',
		'email', 'agreed_minimum_invoice', 'date_of_approval', 'date_of_review', 'approval_status', 'status'
    ];

	public function qualifications(){
		return $this->belongsToMany('App\Qualification','center_qualifications');
		
	}
	public function learners(){
		return $this->hasMany('App\Learner');	
	}
	public function user(){
		return $this->hasOne('App\User');	
	}
}
 