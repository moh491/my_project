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
            'completion_rate'=>80,
            'completed_projects'=>10,
            're_employment_rate'=>90,
            'response_speed'=>"2 h and 30 min",
            'total_balance'=>200,
            'available_balance'=>150,
            'holded_balance'=>50,
            'bending_offers'=>10,
            'in_progress_offers'=>3,
            'completed_offers'=>3,
            'rejected_offers'=>2,
            'about'=>$this->about,
            'languages'=>$this->languages()->select('language', 'level')->get(),
        ];
    }
}
