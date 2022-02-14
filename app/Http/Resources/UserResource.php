<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'role' => $this->role,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'two_factor_secret' => $this->two_factor_secret,
            'two_factor_recovery_codes' => $this->two_factor_recovery_codes,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
