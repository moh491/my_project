<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class OfferResource extends JsonResource
{
    public static function collection($resource): LengthAwarePaginator|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if ($resource instanceof LengthAwarePaginator) {
            return $resource->setCollection($resource->getCollection()->mapInto(static::class));
        }

        return parent::collection($resource);
    }
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
