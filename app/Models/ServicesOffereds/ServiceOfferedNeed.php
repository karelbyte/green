<?php

namespace App\Models\ServicesOffereds;

use App\Models\Element;
use Illuminate\Database\Eloquent\Model;

class ServiceOfferedNeed extends Model
{
    protected $table = 'services_offereds_needs';

    protected $keyType = 'integer';

    protected $fillable = ['services_offereds_detail_id', 'element_id', 'cant'];

    public $timestamps = false;

    public function element () {

        return $this->hasOne(Element::class, 'id', 'element_id');
    }
}
