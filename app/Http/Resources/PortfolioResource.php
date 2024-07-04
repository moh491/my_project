<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class PortfolioResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'skills'=>$this->skills()->pluck('name'),
            'contributors' => $this->freelancers->map(function ($freelancer) {
                return [
                    'profile' => app('baseUrl') . $freelancer->profile,
                    'id' => $freelancer->id,
                ];
            }),
            'preview_image'=> app('baseUrl') . $this->preview,
        ];
    }
}
