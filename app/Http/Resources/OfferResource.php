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
        $array =  [
            'id' => $this->id,
            'duration' => $this->duration,
            'budget' => $this->budget,
            'description' => $this->description,
            'worker_type' => $this['worker_type'],
            'status' => $this['status'],
            'created_at' => $this->created_at->format('Y,m,d'),
        ];

        if ($this['worker_type'] === 'App\Models\Freelancer') {
            $array['worker'] = [
                'type' => 'freelancer',
                'details' => [
                    'id' => $this->worker->id,
                    'name' => $this->worker->first_name . ' ' . $this->worker->last_name,
                    'email' => $this->worker->email,
                    'profile'=>$this->worker->profile,
                    'about' => $this->worker->about,
                    'skills' => $this->worker->skills->pluck('name'),
                ],
            ];
        } else {
            $array['worker'] = [
                'type' => 'team',
                'details' => [
                    'id' => $this->worker->id,
                    'name' => $this->worker->name,
                    'profile' => $this->worker->logo,
                    'link' => $this->worker->link,
                    'about' => $this->worker->about,
                ],
            ];
        }

        return  $array;
    }
}
