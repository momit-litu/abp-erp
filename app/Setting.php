<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'company_name','short_name','site_name','admin_email','logo','certificate_signeture','admin_mobile','site_url','admin_url','address',
    ];
}
