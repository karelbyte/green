<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'start' => $this->moment . ' ' . $this->timer,
            'end'   => $this->moment . ' ' . '23:59:00',
            'data'  => $this->landspacer,
            'title' => $this->title
        ];
    }
}
