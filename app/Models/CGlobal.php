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
    protected $fillable = ['client_id', 'user_id', 'type_contact_id', 'repeater', 'type_motive_id', 'required_time', 'type_compromise_id', 'note'];

    protected $hidden = ['created_at', 'updated_at'];


    public function Contact() {

        return $this->hasOne('App\Models\TypeContact', 'id', 'type_contact_id');

    }

    public function Motive() {

        return $this->hasOne('App\Models\TypeMotive', 'id', 'type_motive_id');

    }

    public function Compromise() {

        return $this->hasOne('App\Models\TypeCompromise', 'id', 'type_compromise_id');

    }
}
