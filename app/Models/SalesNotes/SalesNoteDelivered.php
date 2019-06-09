<?php

namespace App\Models\SalesNotes;

use App\Models\Element;
use Illuminate\Database\Eloquent\Model;

class SalesNoteDelivered extends Model
{
    protected $keyType = 'integer';

    protected $fillable = ['sale_id', 'element_id', 'cant', 'delivered'];

    public $timestamps = false;

    public function element() {

        return $this->hasOne(Element::class, 'id', 'element_id');
    }
}
