<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    public $timestamps = false;

    protected $table = 'user_positions';

    protected $fillable = ['name'];

}
