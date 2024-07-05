<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name'=>$this->first_name.' '.$this->last_name,
            'location'=>$this->location,
            'position' => [
                'id' => $this->position->id,
                'name' => $this->position->name,
                ],
            'field' => [
                'id' => $this->position->field->id,
                'name' => $this->position->field->name,
            ],
            'time_zone'=>$this->time_zone,
            'profile'=>app('baseUrl').$this->profile,
        ];
    }
}
