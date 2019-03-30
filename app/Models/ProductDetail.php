<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $product_id
 * @property int $element_id
 * @property float $cant
 * @property float $price
 * @property integer $alert
 * @property string $created_at
 * @property string $updated_at
 */
class ProductDetail extends Model
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
    protected $fillable = ['product_id', 'element_id', 'cant', 'price', 'alert', 'created_at', 'updated_at'];

}
