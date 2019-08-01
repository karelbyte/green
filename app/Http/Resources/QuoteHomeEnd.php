<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteHomeEnd extends JsonResource
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
            'cag' => $this->globals->id,
            'check_date' => Carbon::parse( $this->moment)->format('d-m-Y'),
            'client'   => $this->globals->client->name,
            'phone'  =>  $this->globals->client->phone,
            'email'  =>  $this->globals->client->email,
            'user' => $this->globals->user->name,
            'motive' => $motive
        ];
    }
}
