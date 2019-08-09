<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class MaintenanceAlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $acestor = \App\Models\SalesNotes\SalesNoteDetails::query()->with(['sale' => function ($q) {
            $q->with('globals');
        }])->find($this->sales_note_details_id);

        $ultimo = $this->load('mlast')->mlast[0];
            $date = $ultimo['moment'];
        if ($this->load('details')->details()->count() === 1) {
            $newDate = \Carbon\Carbon::parse($date)->format('d-m-Y');
        } else {
            $newDate = \Carbon\Carbon::parse($date)->addDays($this->timer)->format('d-m-Y');
        }

        return [
            'id' => $this->id,
            'cag' => $acestor->sale->global_id,
            'moment' =>$newDate,
          //  'time' => $ultimo['visiting_time'],
            'service' => $acestor['descrip'],
            'client'   => $acestor->sale->globals->client->name,
            'user' =>  $acestor->sale->globals->user->name
        ];
    }
}
