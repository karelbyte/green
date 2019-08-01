<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitHomeNotification extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $motive = (int) $this->global->type_motive === 2 ? $this->global->MotiveServices->name
            :  $this->global->MotiveProducts->name;

        return [
            'id' => $this->global->quote === null ?  0 : $this->global->quote->id,
            'cag' => $this->global->id,
            'client'   => $this->global->client->name,
            'address'  =>  $this->global->client->street  . ' #' . $this->global->client->home_number . ' ' . $this->global->client->colony,
            'referen'  =>  $this->global->client->referen,
            'moment' => Carbon::parse($this->moment)->format('d-m-Y'),
            'timer' => $this->timer,
            'user' => $this->user->name,
            'motive' => $motive
        ];
    }
}
