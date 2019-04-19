<?php

namespace App\Models\ProductOffereds;;

use App\Models\Element;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $products_offereds_detail_id
 * @property int $element_id
 * @property int $cant
 */
class ProductOfferedNeed extends Model
{

    protected $table = 'products_offereds_needs';

    protected $keyType = 'integer';

    protected $fillable = ['products_offereds_detail_id', 'element_id', 'cant'];

    public $timestamps = false;

    public function element () {

        return $this->hasOne(Element::class, 'id', 'element_id');
    }

}
