<?php


namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
	protected $fillable = [
        'category_name', 'placeholders'
    ];
}
