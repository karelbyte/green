<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceptionType extends Model
{
    protected $table = 'receptions_type';

    protected $fillable = [
        'id', 'name'
    ];

    public $timestamps = false;


    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
