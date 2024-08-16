<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EndPointProjectOwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->first_name . ' ' . $this->last_name,
            'location' => $this->location,
            'time_zone' => $this->time_zone,
            'about' => $this->about,
            'withdrawal_balance'=>$this->withdrawal_balance,
            'available_balance'=>$this->available_balance,
            'suspended_balance'=>$this->suspended_balance,
            'projects' => $this->projects->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'status' => $project->status,
                    'skills' => $project->skills()->select('skills.id as skill_id', 'skills.name')->get()->map(function ($skill) {
                        return [
                            'id' => $skill->skill_id,
                            'name' => $skill->name,
                        ];
                    }),
                ];
            }),
        ];
    }
}
