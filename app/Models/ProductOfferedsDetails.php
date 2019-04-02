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
class ProductOfferedsDetails extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $table = 'products_offereds_details';

    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [ 'products_offereds_id', 'name', 'init', 'end'];


    public $timestamps = false;

}
