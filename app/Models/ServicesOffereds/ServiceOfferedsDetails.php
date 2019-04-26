<?php

namespace App\Models\ServicesOffereds;

use App\Models\Measure;
use Illuminate\Database\Eloquent\Model;


class ServiceOfferedsDetails extends Model
{
    protected $table = 'services_offereds_details';

    protected $keyType = 'integer';

    protected $fillable = ['services_offereds_id', 'name', 'init', 'end', 'price', 'measure_id'];

    public $timestamps = false;

    public function Measure () {

        return $this->hasOne(Measure::class, 'id', 'measure_id');
    }

    public function needs() {

        return $this->hasMany(ServiceOfferedNeed::class, 'services_offereds_detail_id', 'id');
    }
}
