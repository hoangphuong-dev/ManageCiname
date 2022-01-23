<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaretakerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'avatar_url' => $this->avatar_url,
            'educations' =>  $this->educations ? UserEducationResource::collection($this->educations)->resolve() : [],
            'experiences' =>  $this->experiences ?
                UserExperienceResource::collection($this->experiences)->resolve() : [],
            'has_experiences' =>  $this->experiences->count() > 0 ? 1 : 0,
            'qualifications' =>   $this->qualifications ?
                UserQualificationResource::collection($this->qualifications)->resolve() : [],
            'user_info' => UserInfoResource::make($this->userInfo)
        ]);
    }
}
