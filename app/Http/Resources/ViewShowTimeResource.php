<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewShowTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'trailler' => $this->trailler,
            'movie_id' => $this->movie_id,
            'cinema_id' => $this->cinema_id,
            'day' => $this->day,
            'sum_show_time' => $this->sum_show_time,
        ];
    }
}
