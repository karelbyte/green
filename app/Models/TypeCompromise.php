<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class TypeCompromise extends Model
{

    const SALE_NOTE = 1;
    const QUOTE_DISTANCE = 2;
    const QUOTE_HOME = 3;
    const INFO_SEND = 4;

    protected $keyType = 'integer';

    protected $fillable = ['name', 'created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at'];

}
