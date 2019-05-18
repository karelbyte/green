<?php

namespace App\Models\CGlobal;


use App\Models\Client;
use App\Models\LandScaper;
use App\Models\ProductOffereds\ProductOffereds;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;
use App\Models\ServicesOffereds\ServiceOffereds;
use App\Models\TypeCompromise;
use App\Models\TypeContact;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;


class CGlobal extends Model
{
    protected $table = 'cglobals';

    public $timestamps = false;

    protected $keyType = 'integer';

    protected $fillable = [ 'moment', 'client_id', 'user_id', 'type_contact_id', 'repeater', 'type_motive',  'type_motive_id',

                          'required_time', 'type_compromise_id', 'note', 'status_id', 'traser'];

    public function user () {

        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Contact() {

        return $this->hasOne(TypeContact::class, 'id', 'type_contact_id');

    }

    public function MotiveServices() {

        return $this->hasOne(ServiceOffereds::class, 'id', 'type_motive_id');

    }

    public function MotiveProducts() {

        return $this->hasOne(ProductOffereds::class, 'id', 'type_motive_id');

    }

    public function Compromise() {

        return $this->hasOne(TypeCompromise::class, 'id', 'type_compromise_id');

    }

    public function Client() {

        return $this->hasOne(Client::class, 'id', 'client_id');

    }

    public function Attended() {

        return $this->hasOne(User::class, 'id', 'user_id');

    }

    public function Status() {

        return $this->hasOne(CGlobalStatus::class, 'id', 'status_id');

    }

    public function LandScaper() {
        return $this->hasOne(LandScaper::class, 'cglobal_id', 'id');
    }

    public function Info () {
        return $this->hasMany(CGlobalInfo::class, 'cglobal_id', 'id');
    }

    public function Documents () {
        return $this->hasOne(CGlobalInfoClient::class, 'cglobal_id', 'id');
    }

    public function SaleNote () {
        return $this->hasOne(SalesNote::class, 'global_id', 'id');
    }


    public function Quote () {
        return $this->hasOne(Quote::class, 'cglobal_id', 'id');
    }

}
