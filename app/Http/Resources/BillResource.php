<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'status' => $this->status,
            'user' => $this->user ? UserResource::make($this->user)->resolve() : [],
            'voucher' => $this->user ? VoucherResource::make($this->voucher)->resolve() : [],
            'total_money' => number_format($this->total_money),
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
