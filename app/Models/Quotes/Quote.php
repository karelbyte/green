<?php

namespace App\Models\Quotes;

use App\Models\CGlobal;
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
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['uid', 'cglobal_id', 'type_quote_id', 'moment', 'ext', 'status_id'];

    protected $hidden = ['created_at', 'updated_at'];


    public function details() {

        return $this->hasMany(QuoteDetails::class, 'quote_id', 'id');
    }

    public function docs() {

        return $this->hasMany(QuoteDoc::class, 'quote_id', 'id');
    }

    public function globals() {

        return $this->belongsTo(CGlobal::class, 'cglobal_id', 'id');
    }

    public function status() {

        return $this->hasOne(QuoteStatus::class, 'id', 'status_id');
    }
}
