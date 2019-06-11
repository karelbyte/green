<?php

namespace App\Models;

use App\Models\CGlobal\CGlobal;
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

    protected $fillable = ['code', 'name', 'contact', 'email', 'movil', 'phone', 'street', 'home_number',
        'colony', 'referen', 'register_to'];

    public function user () {

        return $this->hasOne(User::class, 'id', 'register_to');
    }

    public function cags() {
        return $this->hasMany(CGlobal::class, 'client_id', 'id');
    }

    public $timestamps = false;

}
