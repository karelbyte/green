<?php

namespace App\Models\SalesNotes;

use App\Models\Maintenances\Maintenance;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $global_id
 * @property string $descrip
 * @property float $cant
 * @property float $price
 */
class SalesNoteDetails extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['sale_id', 'type_item', 'item_id', 'descrip', 'cant', 'price', 'start', 'timer'];


    public $timestamps = false;

    public function maintenances() {

       return $this->hasOne(Maintenance::class, 'sales_note_details_id', 'id');
    }

}
