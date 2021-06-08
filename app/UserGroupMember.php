<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroupMember extends Model
{
    protected $table = 'user_group_members';

    protected $fillable = [
        'group_id','user_id','status',
    ];
}
