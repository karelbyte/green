<?php

namespace App\Models;

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
    protected $fillable = ['cglobal_id', 'moment', 'timer', 'note', 'user_uid', 'status_id'];

}
