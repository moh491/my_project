<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class BasicInfoResource extends JsonResource
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
        return[
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
