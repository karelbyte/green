<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $reception_id
 * @property int $item_id
 * @property float $cant
 * @property string $created_at
 * @property string $updated_at
 */
class ReceptionDetail extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'receptions_details';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['reception_id', 'item_id', 'cant', 'created_at', 'updated_at'];

}
