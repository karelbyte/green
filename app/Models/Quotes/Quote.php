<?php

namespace App\Models\Quotes;

use App\Models\CGlobal\CGlobal;
use App\Models\TypeWaySendInfo;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $uid
 * @property int $cglobas_id
 * @property string $moment
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 */
class Quote extends Model
{
    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['uid', 'cglobal_id', 'descrip', 'token', 'type_send_id', 'type_check_id', 'check_date',

        'specifications', 'type_quote_id', 'sends', 'moment', 'emit', 'ext', 'status_id'];


    public function getEmitAttribute($value)
    {
        if ($value === null) { return ''; }
        return Carbon::parse($value)->format('g:i A');
    }

    public function details() {

        return $this->hasMany(QuoteDetails::class, 'quote_id', 'id');
    }

    public function docs() {

        return $this->hasMany(QuoteDoc::class, 'quote_id', 'id');
    }

    public function TypeSend() {

        return $this->hasOne(TypeWaySendInfo::class, 'id', 'type_send_id');
    }

    public function TypeCheck() {

        return $this->hasOne(TypeWaySendInfo::class, 'id', 'type_send_id');
    }

    public function globals() {

        return $this->belongsTo(CGlobal::class, 'cglobal_id', 'id');
    }

    public function Notes() {

        return $this->hasMany(QuotesNote::class, 'quote_id', 'id');
    }

    public function status() {

        return $this->hasOne(QuoteStatus::class, 'id', 'status_id');
    }

}
