<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDetialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'status' => $this->status,
            'min_budget' => $this->min_budget,
            'max_budget' => $this->max_budget,
            'duration' => $this->duration,
            'date_posted' => $this->created_at->format('Y,m,d'),
            'description' => $this->description,
            'project_owner'=>
            [
                'id'=>$this->project_owner->id,
                'name'=>$this->project_owner->first_name . ' ' . $this->project_owner->last_name,
                'about'=>$this->project_owner->about
            ],
            'offers_average' => $this->offers()->avg('budget'),
            'offers_number' => $this->offers()->count(),
            'required_skills' => $this->skills->pluck('name'),

        ];
    }
}
