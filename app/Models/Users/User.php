<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active_id', 'position_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function findUid($uid) {

        return self::query()->where('uid', $uid)->first();
    }

    static public function ifexis($email) {

        return empty(self::query()->where('email', $email)->first());
    }

    public function status () {

        return $this->hasOne('App\Models\Users\UserStatus', 'id', 'active_id');
    }

    public function position () {

        return $this->hasOne('App\Models\Users\UserPosition', 'id', 'position_id');
    }
}
