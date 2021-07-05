<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $table = 'student_documents';
    public $timestamps = false;
    
    protected $fillable = [
        'student_id', 'document_name',  'type','size'
    ];
    
}
