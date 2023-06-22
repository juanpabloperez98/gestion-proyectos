<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'titulo'      => $this->titulo,
            'description'     => $this->description,
            'date_start'     => $this->date_start,
            'date_end'     => $this->date_end,
            'user'     => $this->user
        ];
    }
}
