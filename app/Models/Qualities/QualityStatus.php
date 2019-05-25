<?php

namespace App\Models\Qualities;

use Illuminate\Database\Eloquent\Model;

class QualityStatus extends Model
{
    protected $table = 'quality_status';

    public $timestamps = false;

   protected $fillable = ['name'];
}
