<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'duration' => $this->duration,
            'budget' => $this->budget,
            'description' => $this->description,

            'project' => [
                'id' => $this->project->id,
                'title' => $this->project->title,
                'min_budget' => $this->project->min_budget,
                'max_budget' => $this->project->max_budget,
            ],

            'worker_type' => $this->worker_type,
            'worker_id' => $this->worker_id,
            'created_at' => $this->created_at->format('Y,m,d'),
        ];
    }
}
