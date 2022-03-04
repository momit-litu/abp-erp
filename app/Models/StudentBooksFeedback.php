<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBooksFeedback extends Model
{

    protected $fillable= [
        'id',  'student_book_id', 'feedback',
    ];
}
