<?php

namespace App\Models\Qualities;

use App\Models\CGlobal\CGlobal;
use App\Models\Quotes\QuoteStatus;
use Illuminate\Database\Eloquent\Model;


class Quality extends Model
{

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['cglobal_id', 'moment', 'confirm', 'url_doc', 'status_id', 'client_comment'];

    public function global()
    {
        return $this->hasOne(CGlobal::class, 'id', 'cglobal_id');
    }

    public function Status() {
        return $this->hasOne(QualityStatus::class, 'id', 'status_id');
    }
}
