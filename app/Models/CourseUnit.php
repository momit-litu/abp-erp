<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUnit extends Model
{
	protected $table ='courses_units';
     protected $fillable = [
        'unit_id','course_id','type','status',
    ];
}
