<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->review->id,
            'professionalism'=>$this->review->professionalism,
            'communication'=>$this->review->communication,
            'commit_to_deadlines'=>$this->review->commit_to_deadlines,
            're_employee'=>$this->review->re_employee,
            'description'=>$this->review->description,
            'project' => [
                'id' => $this->id,
                'title' => $this->title,
                'project_owner' => [
                    'id' => $this->worker_id,
                    'full_name' => $this->project_owner->first_name,
                    'profile' => $this->project_owner->profile
                ]
            ],
            'created_at'=>$this->created_at,
        ];
    }
}
