<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class TypeInfo extends Model
{
    protected $keyType = 'integer';

    protected $table = 'types_infos';

    protected $fillable = ['name', 'created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at'];

    public function Detail () {

        return $this->hasMany(TypeInfoDetail::class, 'info_id', 'id');
    }

}
