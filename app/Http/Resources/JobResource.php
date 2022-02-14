<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class JobResource extends JsonResource
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
            'name' =>  $this->name,
            'hospital_name' =>  $this->hospital_name,
            'images' =>  JobImageReSource::collection($this->whenLoaded('images')),
            'processes' =>  JobProcessResource::collection($this->whenLoaded('processes')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'address' => $this->address,
            'nearest_station' => $this->nearest_station,
            'map_station' => $this->map_station,
            'advantages' => $this->advantages,
            'wage_min' => $this->wage_min,
            'wage_max' => $this->wage_max,
            'annual_income_min' => $this->annual_income_min,
            'annual_income_max' => $this->annual_income_max,
            'type_of_work' => $this->type_of_work,
            'type_of_work_name' => $this->type_of_work_name,
            'working_hours' => $this->working_hours,
            'holidays' => $this->holidays,
            'number_annual_holidays' => $this->number_annual_holidays,
            'description' => $this->description,
            'occupation' => $this->occupation,
            'certificate' => $this->certificate,
            'years_experience' => $this->years_experience,
            'skills' => $this->skills,
            'experience_priority' => $this->experience_priority,
            'benefits' => $this->benefits,
            'comapany_name' => $this->comapany_name,
            'comapany_establishment' => Carbon::parse($this->comapany_establishment)->format('c'),
            'comapany_introduce' => $this->comapany_introduce,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'isJobApply' => $this->whenLoaded('jobApplyPending') instanceof MissingValue ? false : ($this->jobApplyPending !== null),
            'isJobReject' => count($this->whenLoaded('jobApplyReject') instanceof MissingValue ? [] : $this->jobApplyReject) > 0,
            'isFavorite' => count($this->whenLoaded('favorites') instanceof MissingValue ? [] : $this->favorites) > 0,
            'jobApplyCount' => $this->job_apply_count ?? 0,
            'rateCount' => $this->rate_count ?? 0,
            'rateAverage' => $this->rate_average ?? 0,
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
