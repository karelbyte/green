<?php

namespace App\Models;

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
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $table = 'products_offereds';

    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name'];


    public $timestamps = false;

    public function details() {

        return $this->hasMany(ProductOfferedsDetails::class, 'products_offereds_id', 'id');
    }

}
