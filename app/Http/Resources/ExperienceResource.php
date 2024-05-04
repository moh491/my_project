<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'position'=>$this->position->name,
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'logo' => $this->company->logo,
            ],
            'employment_type'=>$this->employment_type,
            'location_type'=>$this->location_type,
            'location'=>$this->location,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'description'=>$this->description,
        ];
    }
}
