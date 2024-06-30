<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectResource extends JsonResource
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
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'title' => $this->title,
            'description' => $this->description,
            'field' =>
                [
                'id' => $this->field->id,
                'name' => $this->field->name,
                ],
        ] ;
    }
}
