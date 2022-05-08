<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'image' => $this->user->image,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'cinema_id' => $this->cinema_id,
            'type_of_work' => $this->type_of_work,
            'status' => $this->status,
        ];
    }
}
