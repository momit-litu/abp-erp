<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchBook extends Model
{

    protected $fillable= [
        'id',  'book_no', 'batch_id', 'status','created_by'
    ];
}
