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
            'files' => $this->files,
            'project' => [
                'id' => $this->project->id,
                'title' => $this->project->title,
                'description' => $this->project->description,
                'min_budget' => $this->project->min_budget,
                'max_budget' => $this->project->max_budget,
                'duration' => $this->project->duration,
                'status' => $this->project->status,
                'project_owner_id' => $this->project->project_owner_id,
                'field_id' => $this->project->field_id,
                'worker_type' => $this->project->worker_type,
                'worker_id' => $this->project->worker_id,
            ],
            'worker_type' => $this->worker_type,
            'worker_id' => $this->worker_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];    }
}
