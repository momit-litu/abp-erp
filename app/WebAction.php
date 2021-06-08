<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebAction extends Model
{
    protected $table = 'actions';

    protected $fillable = [
        'activity_name','module_id','status','is_menu',
    ];
}
