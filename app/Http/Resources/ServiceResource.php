<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceResource extends JsonResource
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
    public function averageRating()
    {
        return $this->allRequests()
            ->whereNotNull('rating')
            ->avg('rating');
    }

    public function ratingCount()
    {
        return $this->allRequests()
            ->whereNotNull('rating')
            ->count();
    }
    public function getStartingPrice()
    {
        return $this->plans()->min('price');
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'starting_price' => $this->getStartingPrice(),
            'rating' => $this->averageRating(),
            'ratings_count' => $this->ratingCount(),
            'preview' => app('baseUrl') . $this['preview'],
        ];
    }
}
