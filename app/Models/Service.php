<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property integer $init
 * @property integer $end
 * @property float $price
 * @property string $created_at
 * @property string $updated_at
 */
class Service extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'init', 'end', 'price', 'created_at', 'updated_at'];


    protected $hidden = [
        'created_at', 'updated_at'
    ];


}
