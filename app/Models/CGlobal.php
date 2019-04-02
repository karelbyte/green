<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $client_id
 * @property int $user_id
 * @property int $type_contact_id
 * @property integer $repeater
 * @property integer $type_motive_id
 * @property integer $required_time
 * @property integer $type_compromise_id
 * @property string $note
 * @property string $created_at
 * @property string $updated_at
 */
class CGlobal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cglobals';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [ 'moment', 'client_id', 'user_id', 'type_contact_id', 'repeater', 'type_motive',  'type_motive_id',

                          'required_time', 'type_compromise_id', 'note', 'status_id'];

    protected $hidden = ['created_at', 'updated_at'];


    public function Contact() {

        return $this->hasOne('App\Models\TypeContact', 'id', 'type_contact_id');

    }

    public function MotiveServices() {

        return $this->hasOne(ProductOffereds::class, 'id', 'type_motive_id');

    }

    public function MotiveProducts() {

        return $this->hasOne(ServiceOffereds::class, 'id', 'type_motive_id');

    }

    public function Compromise() {

        return $this->hasOne('App\Models\TypeCompromise', 'id', 'type_compromise_id');

    }

    public function Client() {

        return $this->hasOne('App\Models\Client', 'id', 'client_id');

    }

    public function Attended() {

        return $this->hasOne('App\Models\User', 'id', 'user_id');

    }

    public function Status() {

        return $this->hasOne('App\Models\CGlobalStatus', 'id', 'status_id');

    }

    public function LandScaper() {

        return $this->hasOne(LandScaper::class, 'cglobal_id', 'id');

    }

    public function Info () {
        return $this->hasMany(CGlobalInfo::class, 'cglobal_id', 'id');
    }

    public function Documents () {

        return $this->hasOne(CGlobalInfoClient::class, 'cglobal_id', 'id');
    }


}
