<?php

namespace App\Models\Maintenances;

use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{
    public $timestamps = false;

    protected $fillable = ['maintenance_id', 'moment', 'note', 'price', 'status_id'];

}
