<?php

namespace App\Models\Quotes;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $quote_id
 * @property int $cant
 * @property int $descrip
 * @property float $price
 * @property float $total
 * @property string $created_at
 * @property string $updated_at
 */
class QuoteDetails extends Model
{
    protected $table = 'quotes_details';

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['quote_id', 'type_item', 'item_id', 'cant', 'descrip', 'price'];

}
