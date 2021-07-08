<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    protected $fillable= [
        'id', 'batch_id', 'student_id','batch_fees_id','total_payable','total_paid','balance','status'
    ];
    
}
