<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeInfoDetail extends Model
{
   protected $table = 'type_info_details';

   protected $hidden = ['created_at', 'updated_at', 'info_id'];
}
