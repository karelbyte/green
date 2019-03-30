<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $cglobal_id
 * @property string $moment
 * @property string $timer
 * @property string $created_at
 * @property string $updated_at
 */
class Calendar extends Model
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
    protected $fillable = ['cglobal_id', 'moment', 'timer', 'title', 'status_id'];

    public $timestamps = false;

    public function landspacer () {

        return $this->hasOne(LandScaper::class, 'cglobal_id', 'cglobal_id');
    }

}
