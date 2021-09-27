<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'company_name','short_name','site_name','admin_email','logo','fade_logo','admin_mobile','site_url','admin_url','address','bkash_mobile_no', 'rocket_mobile_no','bill_date'
    ];
}
