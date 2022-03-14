<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateFeedback extends Model
{

    protected $fillable= [
        'id',  'batch_student_id', 'feedback',
    ];
}
