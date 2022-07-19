<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowTimeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->room->name,
            'sum_seat' => $this->room->seats_count,
            'seat_empty' => $this->room->seats_count - $this->tickets_count,
            'movie_id' => $this->movie_id,
            'room_id' => $this->room_id,
            'time_start' => date_format(date_create($this->time_start), "H:i"),
            'time_end' => date_format(date_create($this->time_end), "H:i"),
        ];
    }
}
