<?php

namespace App\Models\Quotes;

use App\Models\Measure;
use Illuminate\Database\Eloquent\Model;

class QuoteDetails extends Model
{
    protected $table = 'quotes_details';

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['quote_head_id', 'type_item', 'measure_id', 'item_id', 'cant', 'descrip', 'price'];

    public function measure() {
        return $this->hasOne(Measure::class, 'id', 'measure_id');
    }

}
