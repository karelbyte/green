<?php

namespace App\Models\SalesNotes;

use App\Models\CGlobal\CGlobal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class SalesNote extends Model
{
    // ORIGEN DE LA NOTA DE VENTA
    const ORIGIN_CAG = 1;
    const ORIGIN_SALE_NOTE = 2;

    protected $table = 'salesnotes';

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['global_id', 'moment', 'emit', 'advance', 'status_id', 'strategy', 'status_id', 'origin', 'have_iva'];

    public function getEmitAttribute($value): string
    {
        if ($value === null) { return ''; }
        return Carbon::parse($value)->format('g:i A');
    }

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

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')
            ->where('type_item', 2);
    }

    public function details_services () {

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')
            ->where('type_item', 3);
    }

    public function products_services () {

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')
            ->wherein('type_item', [2, 3])->whereNotNull('start');
    }

    public function products_services_null () {

        return $this->hasMany(SalesNoteDetails::class, 'sale_id', 'id')
            ->wherein('type_item', [2, 3]);
    }

    public function delivered () {

        return $this->hasMany(SalesNoteDelivered::class, 'sale_id', 'id');
    }

    public function total() {
      $data = $this->details;
      $total = $data->reduce( function ($carry, $item) {
            return $carry + ($item['cant'] * $item['price']);
        });
      return number_format($total, '2', '.', '');
    }

}
