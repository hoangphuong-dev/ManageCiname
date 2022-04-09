<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'cinema_id' => $this->cinema_id,
            'name' => $this->name,
            'row_number' => $this->row_number,
            'column_number' => $this->column_number,
            'status' => $this->status,
        ];
    }
}
