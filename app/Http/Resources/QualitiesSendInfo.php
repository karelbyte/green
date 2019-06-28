<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QualitiesSendInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cag' => $this->global->id,
            'moment' => Carbon::parse($this->moment)->format('d-m-Y'),
            'client'   => $this->global->client->name,
            'user' => $this->global->user->name,
        ];
    }
}
