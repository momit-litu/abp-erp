<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{

    protected $fillable = [
        'title', 'details', 'category', 'type'
    ];
	
	public function tempCategory(){
		return $this->hasOne('App\Models\templateCategory','id','category');
	}
}
