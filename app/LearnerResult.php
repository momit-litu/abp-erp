<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearnerResult extends Model
{
    protected $fillable = ['registration_learner_id','unit_id','passed', 'result'];
	
	/*'registration_learner_id','unit_id','passed', 'result'	*/

	public function unit(){
		return $this->hasOne('App\Unit','id','unit_id');
	}
}
