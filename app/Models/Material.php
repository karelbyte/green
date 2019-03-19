<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'code',

        'name',

        'price',

        'measure_id'
    ];

    protected $hidden = [

        'created_at',

        'updated_at'
    ];

    public function Measure () {

        $this->hasOne('App\Models\Measure', 'id', 'measure_id');
    }
}
