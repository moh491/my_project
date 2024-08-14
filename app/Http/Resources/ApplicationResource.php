<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'is_accepted' => $this->is_accepted,
            'status' => $this->status,
            'budget' => $this->budget,
            'experience_year' => $this->experience_year,
            'file' => $this->file,
            'company_name'=>$this->job->company->name,
            'job' => [
                 'id' => $this->job->id,
                'title' => $this->job->title,
                'location_type'=>$this->job->location_type,
                'employment_type'=>$this->job->employment_type,
                'description' => $this->job->description,
                'min_salary' => $this->job->min_salary,
                'max_salary' => $this->job->max_salary,
            ],
            'freelancer' => [
                'id' => $this->freelancer->id,
                'first_name' => $this->freelancer->first_name,
                'last_name' => $this->freelancer->last_name,
                'email' => $this->freelancer->email,
                'location' => $this->freelancer->location,
                'time_zone' => $this->freelancer->time_zone,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
