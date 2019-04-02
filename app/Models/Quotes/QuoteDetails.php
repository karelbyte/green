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
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'quotes_details';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['quote_id', 'cant', 'descrip', 'price', 'total', 'created_at', 'updated_at'];

}
