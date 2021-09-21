<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
      protected $fillable = [
        'name','unit_code','assessment_type','glh','tut','credit_hour','status',
    ];
	
	public function courses(){
		return $this->belongsToMany('App\Models\Course','courses_units');
	}

}

