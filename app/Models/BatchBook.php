<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchBook extends Model
{
    protected $fillable= [
        'id',  'book_no', 'batch_id', 'status','created_by'
    ];
	public function students(){
      return $this->hasMany('App\Models\StudentBook','id','batch_book_id');
    }
	public function batch(){
		return $this->hasOne('App\Models\Batch','id','batch_id');
	}	
}
