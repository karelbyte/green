<?php

namespace App\Models\Maintenances;

use App\Models\Client;
use App\Models\ServicesOffereds\ServiceOfferedsDetails;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $keyType = 'integer';

    protected $fillable = ['client_id', 'sales_note_details_id', 'service_offereds_id', 'timer', 'start',
        'status_id', 'created_at', 'updated_at'];


    public function client () {

        return $this->hasOne(Client::class, 'id', 'client_id');

    }

    public function status () {

        return $this->hasOne(MaintenanceStatus::class, 'id', 'status_id');

    }

    public function service () {

        return $this->hasOne(ServiceOfferedsDetails::class, 'id', 'service_offereds_id');
    }

    public function details () {

        return $this->hasMany(MaintenanceDetail::class, 'maintenance_id', 'id');
    }

}
