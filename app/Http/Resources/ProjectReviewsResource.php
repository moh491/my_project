<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static function collection($resource): LengthAwarePaginator|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if ($resource instanceof LengthAwarePaginator) {
            return $resource->setCollection($resource->getCollection()->mapInto(static::class));
        }

        return parent::collection($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'review' => new ReviewResource($this->review),
            'project' => [
                'id' => $this->id,
                'title' => $this->title,
                'project_owner' => [
                    'id' => $this->worker_id,
                    'full_name' => $this->project_owner->first_name . ' ' . $this->project_owner->last_name,
                    'profile' => app('baseUrl').$this->project_owner->profile
                ]
            ],
            'created_at' => $this->created_at->format('Y,m,d'),
        ];


    }
}
