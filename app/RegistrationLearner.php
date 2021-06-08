<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationLearner extends Model
{
    protected $fillable = ['learner_id','registration_id','pass_status', 'result_claim_date',  'certificate_no', 'is_printd'	];
	/*'learner_id','registration_id','pass_status', 'cirtificate_no', 'is_printd'	*/

	public function learner(){
		return $this->hasOne('App\Learner','id','learner_id');
	}
	public function registration(){
		return $this->hasOne('App\Registration','id','registration_id');
	}
	public function results(){
		return $this->hasMany('App\LearnerResult','registration_learner_id' ); //->withPivot('passed', 'result');
	}				
}
