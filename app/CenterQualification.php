<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterQualification extends Model
{
   protected $fillable = [
        'center_id','qualification_id','status',
    ];
}
