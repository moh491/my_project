<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->routeIs('company.show')) {
            return [
                'id' => $this->id,
                'name' => $this->name,
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'email' => $this->email,
            'location' => $this->location,
            'website' => $this->website,
            'background_image' => $this->background_image,
            'about' => $this->about,
            'field' => [
                'id' => $this->field->id,
                'name' => $this->field->name,
            ],
            'jobs' => $this->jobs->map(function($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'location_type' => $job->location_type,
                    'employment_type' => $job->employment_type,
                    'level' => $job->level,
                    'salary' => $job->min_salary . ' - ' .  $job->max_salary,
                    'date_posted' => $job->created_at->diffForHumans(),
                ];
            }),
        ];
    }
}
