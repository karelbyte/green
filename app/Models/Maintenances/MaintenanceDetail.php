<?php

namespace App\Models\Maintenances;

use App\Models\SalesNotes\SalesNoteStatus;
use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{

    protected $table = 'maintenance_details';

    public $timestamps = false;

    protected $fillable = ['maintenance_id', 'sale_id', 'moment', 'visiting_time',
        'note_gardener', 'note_client', 'price',  'note_advisor',
        'url_commend', 'accept', 'mime', 'status_id'];

    public function maintenance () {
        return $this->hasOne(Maintenance::class, 'id', 'maintenance_id');
    }

    public function status () {
        return $this->hasOne(MaintenaceStatusDetail::class, 'id', 'status_id');
    }

    public function accepts () {
        return $this->hasOne(MaintenaceStatusDetail::class, 'id', 'accept');
    }

}
