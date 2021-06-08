<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['registration_no', 'invoice_no', 'registration_fees','fees_paid_amount', 'center_registration_date',
		'ep_registration_date','status', 'approval_status', 'payment_status', 'remarks', 'center_id', 'qualification_id'
	];
	
	/*'registration_no', 'invoice_no', 'registration_fees','fees_paid_amount', 'center_registration_date',
'ep_registration_date', , 'status', 'approval_status', 'payment_status', 'remarks', 'center_id', 'qualification_id'
*/

	public function center(){ 
		return $this->hasOne('App\Center','id','center_id');
	}
	
	public function qualification(){
		return $this->hasOne('App\Qualification','id','qualification_id');
	}

	public function learners(){
		return $this->belongsToMany('App\Learner','registration_learners')->withPivot('id','pass_status', 'certificate_no', 'is_printd');
	}

}

