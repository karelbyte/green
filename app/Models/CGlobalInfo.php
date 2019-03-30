<?php

namespace App\Models;

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
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cglobal_infos';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['cglobal_id', 'type_info_id', 'type_info_detail_id', 'info_descrip'];


    protected $hidden =  ['created_at', 'updated_at'];


    public function info () {

        return $this->hasOne(TypeInfo::class, 'id', 'type_info_id');
    }

    public function info_det () {

        return $this->hasOne(TypeInfoDetail::class, 'id', 'type_info_detail_id');
    }

}
