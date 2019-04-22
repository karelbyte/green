<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property integer $init
 * @property integer $end
 * @property float $price
 * @property string $created_at
 * @property string $updated_at
 */
class ServiceOfferedsDetails extends Model
{
    protected $table = 'services_offereds_details';

    protected $keyType = 'integer';

    protected $fillable = ['services_offereds_id', 'name', 'init', 'end', 'price', 'measure_id'];

    public $timestamps = false;

    public function Measure () {

        return $this->hasOne(Measure::class, 'id', 'measure_id');
    }
}
