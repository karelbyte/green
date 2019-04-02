<?php

namespace App\Models\Quotes;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $quote_id
 * @property string $name
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class QuoteDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'quotes_docs';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['quote_id', 'name', 'url', 'ext', 'created_at', 'updated_at'];

}
