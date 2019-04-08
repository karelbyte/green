<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{


    protected $fillable = ['element_id', 'cant', 'created_at', 'updated_at'];

    protected $hidden = [

        'created_at',

        'updated_at'
    ];

    public function element() {

        return $this->hasOne(Element::class, 'id', 'element_id');
    }
}
