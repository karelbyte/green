<?php

namespace App\Models\Quotes;

use App\Models\Measure;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $quote_id
 * @property string $descrip
 * @property string $specifications
 * @property boolean $have_iva
 * @property float $discount
 * @property Quote $quote
 */
class QuoteHead extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'quotes_heads';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['quote_id', 'descrip', 'specifications', 'have_iva', 'discount'];


    public function details() {
        return $this->hasMany(QuoteDetails::class, 'quote_head_id', 'id');
    }



    public $timestamps = false;
}
