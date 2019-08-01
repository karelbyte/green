<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesNoteNotClose extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ((int) $this->globals->type_motive === 2 ) {

            $motive =  $this->globals->MotiveServices !== null ? $this->globals->MotiveServices->name : 'NO DEFINIDO';

        } else {
            $motive =  $this->globals->MotiveProducts !== null ? $this->globals->MotiveProducts->name : 'NO DEFINIDO';

        }
        return [
            'id' => $this->id,
            'client'   => $this->globals->client->name,
            'moment' => Carbon::parse($this->moment)->format('d-m-Y'),
            'user' => $this->globals->user->name,
            'motive' => $motive
        ];
    }
}
