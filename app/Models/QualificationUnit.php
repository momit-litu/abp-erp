<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualificationUnit extends Model
{
     protected $fillable = [
        'unit_id','qualification_id','type','status',
    ];
}
