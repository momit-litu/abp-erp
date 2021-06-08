<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'code','title','level_id','tqt','total_credit_hour','registration_fees','status',
    ];
	
	public function level(){
		return $this->hasOne('App\Level','id','level_id');
	}
	
	public function units(){
		return $this->belongsToMany('App\Unit','qualification_units')->withPivot('type');
	}
	public function centers(){
		return $this->belongsToMany('App\Center','center_qualifications');	
	}
}
