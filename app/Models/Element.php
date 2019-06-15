<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'elements';

    protected $fillable = [

        'type',

        'code',

        'name',

        'price',

        'measure_id',

        'wholesale_cant',

       'wholesale_price'
    ];

    public $timestamps = false;

    public function Measure () {

       return $this->hasOne(Measure::class, 'id', 'measure_id');
    }

    public function scopeMaterial($query)
    {
        return $query->where('type', 1);
    }

    public function scopeTool($query)
    {
        return $query->where('type', 2);
    }

}
