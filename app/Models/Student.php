<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'contact_no', 'address','date_of_birth','nid_no','user_profile_image','remarks','status'
    ];


}
