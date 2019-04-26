<?php

namespace App\Models\ServicesOffereds;

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
class ServiceOffereds extends Model
{

    protected $keyType = 'integer';

    protected $table = 'services_offereds';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function details () {

        return $this->hasMany(ServiceOfferedsDetails::class, 'services_offereds_id', 'id');
    }
}
