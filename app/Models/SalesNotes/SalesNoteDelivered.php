<?php

namespace App\Models\SalesNotes;

use Illuminate\Database\Eloquent\Model;

class SalesNoteDelivered extends Model
{
    protected $keyType = 'integer';

    protected $fillable = ['sale_id', 'element_id', 'cant', 'delivered'];

    public $timestamps = false;

}
