<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class TypeContact extends Model
{

    protected $keyType = 'integer';

    protected $fillable = ['name'];

    public $timestamps = false;

}
