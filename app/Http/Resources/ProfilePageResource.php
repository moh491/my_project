<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilePageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function projectCompletedCount()
    {
        return $this->projects()
            ->where('status','Closed')
            ->count();
    }
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'profile'=>app('baseUrl').$this->profile,
            'full_name'=>$this->first_name.' '.$this->last_name,
            'position'=>$this->position->name,
            'rating'=>5,
            'location'=>$this->location,
            'time_zone'=>$this->time_zone,
            'completion_rate'=>$this->projectCompletedCount()/$this->projects()->count()*100,
            'completed_projects'=>$this->projectCompletedCount(),
            're_employment_rate'=>90,
            'response_speed'=>"2 h and 30 min",
            'total_balance'=>$this->suspended_balance+$this->available_balance+$this->withdrawal_balance,
            'suspended_balance'=>$this->suspended_balance,
            'available_balance'=>$this->available_balance,
            'withdrawal_balance'=>$this->withdrawal_balance,
            'bending_offers'=>10,
            'in_progress_offers'=>3,
            'completed_offers'=>3,
            'rejected_offers'=>2,
            'about'=>$this->about,
            'languages' => $this->languages()->select('language as name', 'level')->get()->map(function($language) {
                return [
                    'name' => $language->name,
                    'level' => $language->level,
                ];
            }),
            'skills' => $this->skills()->select('skills.id as skill_id', 'skills.name')->get()->map(function ($skill) {
                return [
                    'id' => $skill->skill_id,
                    'name' => $skill->name,
                ];
            }),
        ];
    }
}
