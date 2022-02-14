<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
            'name_kana' => $this->name_kana,
            'name_kana_given' => $this->name_kana_given,
            'degree_type' => $this->degree_type,
            'age_type' => $this->age_type,
            'postal_code' => $this->postal_code,
            'full_age' => $this->full_age,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'address_furigana' => $this->address_furigana,
            'address_other_code' => $this->address_other_code,
            'address_other' => $this->address_other,
            'address_other_furigana' => $this->address_other_furigana,
            'forte_majors' => $this->forte_majors,
            'hobby' => $this->hobby,
            'sports_cultural' => $this->sports_cultural,
            'health_status' => $this->health_status,
            'health_detail' => $this->health_detail,
            'pr_myself' => $this->pr_myself,
            'job_target' => $this->job_target,
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
