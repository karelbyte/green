<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cglobal_id
 * @property integer $user_id
 * @property integer $for_user_id
 * @property string $start
 * @property string $end
 * @property string $title
 * @property string $contentFull
 * @property boolean $allDay
 * @property boolean $status_id
 */
class Calendar extends Model
{

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['cglobal_id', 'user_id', 'for_user_id', 'start', 'end', 'title', 'contentFull', 'allDay', 'class', 'status_id', 'mant_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
