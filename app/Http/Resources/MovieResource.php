<?php

namespace App\Http\Resources;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'name' => $this->name,
            'director' => $this->director,
            'description' => $this->description,
            'trailer' => $this->trailer,
            'movie_length' => $this->movie_length,
            'rated' => $this->rated,
            'status_switch' => $this->status === Movie::MOVIE_ACTIVE
                ? Movie::MOVIE_ACTIVE
                : Movie::MOVIE_DEACTIVE,
            'created_at' => Carbon::parse($this->created_at)->format('c'),
            'updated_at' => Carbon::parse($this->updated_at)->format('c'),
        ];
    }
}
