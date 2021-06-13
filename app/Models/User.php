<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'student_id','email', 'type', 'center_id', 'user_profile_image','contact_no','remarks','client_id','status','login_status','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Change login status according to $status.
     *
     * @param string $status
     * @return mixed
     */

    public static function LogInStatusUpdate($status)
    {
        if(\Auth::check()){
            if($status=='login') {
                $change_status=1;
            } else {
                $change_status=0;
            }
            $loginstatuschange = \App\Models\User::where('email',\Auth::user()->email)->update(array('login_status'=>$change_status));
            return $loginstatuschange;
        }
    }

	public function user_groups() {
        return $this->hasMany('App\Models\UserGroupMember', 'user_id');
    }

}
