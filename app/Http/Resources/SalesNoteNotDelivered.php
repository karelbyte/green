<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesNoteNotDelivered extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $motive = (int) $this->globals->type_motive === 2 ? $this->globals->MotiveServices->name
            :  $this->globals->MotiveProducts->name;
        return [
            'id' => $this->id,
            'client'  => $this->globals->client->name,
            'moment' => Carbon::parse($this->moment)->format('d-m-Y'),
            'deliverydate' => Carbon::parse($this->deliverydate)->format('d-m-Y'),
            'user' => $this->globals->user->name,
            'motive' => $motive
        ];
    }
}
