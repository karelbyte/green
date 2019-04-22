<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

    protected $keyType = 'integer';


    protected $fillable = ['code', 'name', 'contact', 'email', 'movil', 'phone', 'address', 'created_at', 'updated_at'];


    public $timestamps = false;

}
