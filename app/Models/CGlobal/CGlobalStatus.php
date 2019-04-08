<?php

namespace App\Models\CGlobal;

use Illuminate\Database\Eloquent\Model;

class CGlobalStatus extends Model
{
   protected $table = 'cglobal_status';

   protected $fillable = [
       'id', 'name'
   ];

   public $timestamps = false;


}
