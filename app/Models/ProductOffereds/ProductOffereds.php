<?php

namespace App\Models\ProductOffereds;

use App\Models\Quotes\Quote;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property integer $init
 * @property integer $end
 * @property string $created_at
 * @property string $updated_at
 */
class ProductOffereds extends Model
{
    protected $table = 'products_offereds';

    protected $keyType = 'integer';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function details() {

        return $this->hasMany(ProductOfferedsDetails::class, 'products_offereds_id', 'id');
    }

    public function used () {

        $found = Quote::where('measure_id', $this->id)->first();

        return !empty($found);
    }

}
