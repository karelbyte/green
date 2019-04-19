<?php

namespace App\Models;

use App\Models\Client;
use App\Models\ServiceOffereds;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $client_id
 * @property int $service_offereds_id
 * @property int $timer
 * @property string $start
 * @property string $created_at
 * @property string $updated_at
 */
class Maintenance extends Model
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
    protected $fillable = ['client_id', 'service_offereds_id', 'timer', 'start', 'created_at', 'updated_at'];


    public function client () {

        return $this->hasOne(Client::class, 'id', 'client_id');

    }

    public function service () {

        return $this->hasOne(ServiceOffereds::class, 'id', 'service_offereds_id');
    }

}
