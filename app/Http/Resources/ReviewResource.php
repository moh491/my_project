<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ReviewResource extends JsonResource
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
            'professionalism'=>$this->professionalism,
            'communication'=>$this->communication,
            'commit_to_deadlines'=>$this->commit_to_deadlines,
            'quality'=>$this->quality,
            'experience'=>$this->experience,
            're_employee'=>$this->re_employee,
            'description'=>$this->description,
        ];
    }
}
