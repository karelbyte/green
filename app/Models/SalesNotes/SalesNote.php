<?php

namespace App\Models\SalesNotes;

use App\Models\CGlobal\CGlobal;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $global_id
 * @property string $moment
 * @property float $advance
 * @property integer $status
 */
class SalesNote extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'salesnotes';

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
    protected $fillable = ['global_id', 'moment', 'advance', 'status_id', 'strategy', 'status_id'];


    public function globals() {

        return $this->belongsTo(CGlobal::class, 'global_id', 'id');
    }

    public function status() {

        return $this->hasOne(SalesNoteStatus::class, 'id', 'status_id');
    }

    public function details () {
        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id');
    }

    public function details_inventoris () {

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')->where('type_item', 1);
    }


    public function details_products () {

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')->where('type_item', 2);
    }

    public function details_services () {

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')->where('type_item', 3);
    }


}
