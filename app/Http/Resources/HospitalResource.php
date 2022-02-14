<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
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
            'google_id' => $this->google_id,
            'role' => $this->role,
            'avatar' => $this->avatar,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'hospital_info' =>  $this->hospitalInfo ? HospitalInfoResource::make($this->hospitalInfo)->resolve() : [],
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
