<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'contact_no', 'address','date_of_birth','nid_no','user_profile_image','remarks','status'
    ];
	
	
}
