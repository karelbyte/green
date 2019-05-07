<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    const ADMIN = 1;
    const ACESSOR_OF_GARDEN = 2;
    const LANDSCAPERS = 3;

    public $timestamps = false;

    protected $table = 'user_positions';

    protected $fillable = ['name'];

}
