<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'location' => $this->location,
            'location_type' => $this->location_type,
            'employment_type' => $this->employment_type,
            'level' => $this->level,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'date_posted' => $this->created_at->format('Y,m,d'),
            'description' => $this->description,
            'responsibilities' => json_decode($this['responsibilities']),
            'requirements' => json_decode($this['requirements']),
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'logo' => $this->company->logo,
                'about' => $this['company']['about'],
                'location' => $this->company->location,
                'website' => $this['company']['website'],
                'field' => $this->company->field,
            ],
        ];
    }
}
