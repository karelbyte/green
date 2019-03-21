<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $contact
 * @property string $email
 * @property string $movil
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 */
class Provider extends Model
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
    protected $fillable = ['code', 'name', 'contact', 'email', 'movil', 'phone', 'address', 'created_at', 'updated_at'];


    protected $hidden = ['created_at', 'updated_at'];

}
