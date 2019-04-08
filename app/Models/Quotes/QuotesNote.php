<?php

namespace App\Models\Quotes;

use Illuminate\Database\Eloquent\Model;

class QuotesNote extends Model
{
    public $timestamps = false;

    protected $fillable = [

        'quote_id',

        'note'
    ];
}
