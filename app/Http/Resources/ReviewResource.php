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
            'id'=>$this->review->id,
            'professionalism'=>$this->review->professionalism,
            'communication'=>$this->review->communication,
            'commit_to_deadlines'=>$this->review->commit_to_deadlines,
            'quality'=>$this->review->quality ,
            'experience'=>$this->review->experience,
            're_employee'=>$this->review->re_employee,
            'description'=>$this->review->description,
            'project' => [
                'id' => $this->id,
                'title' => $this->title,
                'project_owner' => [
                    'id' => $this->worker_id,
                    'full_name' => $this->project_owner->first_name.' '.$this->project_owner->last_name,
                    'profile' => $this->project_owner->profile
                ]
            ],
            'created_at'=>$this->created_at,
        ];
    }
}
