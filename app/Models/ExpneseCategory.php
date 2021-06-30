<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpneseCategory extends Model
{
    protected $fillable = [
        'category_name',  'parent_id', 'status'
    ];

    public function parent(){
        return $this->hasOne('App\Models\ExpneseCategory','id','parent_id');
    }
    public function child(){
        return $this->hasMany('App\Models\ExpneseCategory','parent_id','id');
    }




}
