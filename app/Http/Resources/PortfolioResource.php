<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
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
                    'profile' => $freelancer->profile,
                    'id' => $freelancer->id,
                ];
            }),
            'preview_image'=>$this->preview,
        ];
    }
}
