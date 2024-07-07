<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'skills' => $this->skills()->select('skills.id as skill_id', 'skills.name')->get()->map(function ($skill) {
                return [
                    'id' => $skill->skill_id,
                    'name' => $skill->name,
                ];
            }),
            'contributors' => $this->freelancers
                ->when(
                    Auth::guard('Freelancer')->check(),
                    function ($collection) {
                        return $collection->reject(function ($freelancer) {
                            return $freelancer->id == Auth::guard('Freelancer')->user()->id;
                        });
                    }
                )
                ->map(function ($freelancer) {
                    return [
                        'profile' => app('baseUrl') . $freelancer->profile,
                        'id' => $freelancer->id,
                    ];
                })
                ->values(),
            'preview' => app('baseUrl') . $this->preview,
        ];
    }
}
