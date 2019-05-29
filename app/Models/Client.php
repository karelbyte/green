<?php

namespace App\Models;

use App\Models\Users\User;
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
 */
class Client extends Model
{

    protected $keyType = 'integer';

    protected $fillable = ['code', 'name', 'contact', 'email', 'movil', 'phone', 'address', 'register_to'];

    public function user () {

        return $this->hasOne(User::class, 'id', 'register_to');
    }

    public $timestamps = false;

}
