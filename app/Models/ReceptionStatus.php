<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceptionStatus extends Model
{
    protected $table = 'receptions_status';

    protected $fillable = [
        'id', 'name'
    ];

    public $timestamps = false;


    protected $hidden = [
        'id',  'created_at', 'updated_at'
    ];

}
