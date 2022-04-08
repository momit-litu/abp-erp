<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateFeedback extends Model
{

    protected $fillable= [
        'id',  'batch_student_id', 'feedback','created_by'
    ];
	
	public function createdBy(){
		return $this->hasOne('App\Models\User','id','created_by');
	}
}
