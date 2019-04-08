<?php

namespace App\Models\CGlobal;

use Illuminate\Database\Eloquent\Model;

class CGlobalInfoClient extends Model
{
    protected $table = 'cglobal_info_clients';

    public $timestamps = false;

    protected $fillable = ['cglobal_id', 'moment', 'type_info_id'];

    protected $hidden = ['cglobal_id', 'id'];
}
