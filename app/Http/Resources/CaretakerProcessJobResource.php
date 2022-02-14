<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CaretakerProcessJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $arr = parent::toArray($request);
        $jobApply = [];
        if(isset($arr['job_apply_pending'])) {
            $jobApply = $arr['job_apply_pending'];
            unset($arr['job_apply_pending']);
        } else if(isset($arr['job_apply_reject'])) {
            $jobApply = $arr['job_apply_reject'];
            unset($arr['job_apply_reject']);
        }  else if(isset($arr['job_apply_done'])) {
            $jobApply = $arr['job_apply_done'];
            unset($arr['job_apply_done']);
        }

        return array_merge(
            $arr,
            [
                'jobApply' => $jobApply
            ]
        );
    }
}
