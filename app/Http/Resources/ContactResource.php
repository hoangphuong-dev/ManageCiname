<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'sender_id' => $this->sender_id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'question_title' => $this->question_title,
            'question_content' => $this->question_content,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'answer_content' => $this->answer_content,
            'type' => $this->type,
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
