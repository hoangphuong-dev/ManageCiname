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
            'google_id' => $this->google_id,
            'role' => $this->role,
            'avatar' => $this->avatar_url,
            'name' => $this->name,
            'email' => $this->email,
            'user_info' =>  $this->userInfo ? UserInfoResource::make($this->userInfo)->resolve() : [],
            'educations' =>  $this->educations ? UserEducationResource::collection($this->educations)->resolve() : [],
            'experiences' =>  $this->experiences ?
                UserExperienceResource::collection($this->experiences)->resolve() : [],
            'has_experiences' =>  $this->experiences->count() > 0 ? 1 : 0,
            'qualifications' =>   $this->qualifications ?
                UserQualificationResource::collection($this->qualifications)->resolve() : [],
            'status' => $this->status,
            'status_name' => $this->status_name,
            'status_switch' => $this->status === User::ACCOUNT_STATUS_DONE
                ? User::ACCOUNT_STATUS_DONE
                : User::ACCOUNT_STATUS_SUSPEND,
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
