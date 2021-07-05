<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $table = 'student_documents';
    protected $fillable = [
        'student_id', 'document_name',  'type','size'
    ];
    
}
