<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
   protected $fillable = [
        'name','unit_code','assessment_type','glh','tut','credit_hour','status',
    ];
	
	public function hasQualification(){
		return $this->belongsToMany('App\Qualification','qualification_units');
	}
}
