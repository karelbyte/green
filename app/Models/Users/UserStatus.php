<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
   protected $table = 'user_status';

   protected $fillable = [
       'id', 'name'
   ];

   public $timestamps = false;


}
