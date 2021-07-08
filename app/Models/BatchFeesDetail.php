<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchFeesDetail extends Model
{
    protected $fillable= [
        'id',  'batch_fees_id', 'installment_no','amount', 'status'
    ];
}
