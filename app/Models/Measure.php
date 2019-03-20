<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function used () {

        $found = Element::where('measure_id', $this->id)->first();

        return !empty($found);
    }
}
