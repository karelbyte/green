<?php

namespace App\Models\Receptions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $code
 * @property integer $type
 * @property int $user_id
 * @property string $moment
 * @property string $note
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 */
class Reception extends Model
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
    protected $fillable = ['code', 'type', 'user_id', 'moment', 'note', 'status_id', 'created_at', 'updated_at'];


    public function Details() {

        return $this->hasMany(ReceptionDetail::class);
    }


    public function User() {

        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Status() {

        return $this->belongsTo(ReceptionStatus::class);
    }


    public function Types() {

        return $this->belongsTo(ReceptionType::class, 'type', 'id');
    }


    protected $hidden = [

        'created_at',

        'updated_at'
    ];
}
