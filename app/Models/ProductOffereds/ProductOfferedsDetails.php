<?php

namespace App\Models\ProductOffereds;;

use App\Models\Measure;
use Illuminate\Database\Eloquent\Model;

class ProductOfferedsDetails extends Model
{
    protected $table = 'products_offereds_details';

    protected $keyType = 'integer';

    protected $fillable = [ 'products_offereds_id', 'name', 'measure_id', 'init', 'end'];

    public function measure() {

        return $this->hasOne(Measure::class, 'id', 'measure_id');
    }

    public function needs() {

        return $this->hasMany(ProductOfferedNeed::class, 'products_offereds_detail_id', 'id');
    }

    public $timestamps = false;

}
