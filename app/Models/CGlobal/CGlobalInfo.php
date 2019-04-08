<?php

namespace App\Models\CGlobal;

use App\Models\TypeInfo;
use App\Models\TypeInfoDetail;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $cglobal_id
 * @property int $type_info_id
 * @property int $type_info_detail_id
 * @property string $info_descrip
 * @property string $created_at
 * @property string $updated_at
 */
class CGlobalInfo extends Model
{
    protected $table = 'cglobal_infos';

    protected $keyType = 'integer';

    protected $fillable = ['cglobal_id', 'type_info_id', 'type_info_detail_id', 'info_descrip'];

    public $timestamps = false;

    public function info () {

        return $this->hasOne(TypeInfo::class, 'id', 'type_info_id');
    }

    public function info_det () {

        return $this->hasOne(TypeInfoDetail::class, 'id', 'type_info_detail_id');
    }

}
