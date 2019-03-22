<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $www
 * @property string $rfc
 * @property string $created_at
 * @property string $updated_at
 */
class Company extends Model
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
    protected $fillable = ['name', 'address', 'email', 'www', 'rfc', 'phone1', 'phone2'];


    protected $hidden = ['created_at', 'updated_at'];
}
