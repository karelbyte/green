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

        'measure_id'
    ];

    protected $hidden = [

        'created_at',

        'updated_at'
    ];

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

    public function used () {

        $found = Inventori::where('element_id', $this->id)->first();

        return !empty($found);
    }
}
