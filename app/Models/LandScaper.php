<?php

namespace App\Models;

use App\Models\CGlobal\CGlobal;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $cglobal_id
 * @property string $moment
 * @property string $timer
 * @property string $note
 * @property int $user_id
 * @property int $status_id
 */
class LandScaper extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'landscapers';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';


    public $timestamps = false;
    /**
     * @var array
     */

   /* public function getTimerAttribute($value)
    {
        if ($value === null) { return ''; }
        return Carbon::parse($value)->format('g:i A');
    }*/

    protected $fillable = ['cglobal_id', 'moment', 'timer', 'note', 'user_uid', 'status_id'];


    public function user () {

        return $this->hasOne(User::class, 'uid', 'user_uid');
    }


    public function global () {

        return $this->hasOne(CGlobal::class, 'id', 'cglobal_id');
    }

}
