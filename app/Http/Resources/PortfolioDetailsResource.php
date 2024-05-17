<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioDetailsResource extends JsonResource
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
            'date'=>$this->date,
            'description'=>$this->description,
            'skills'=>$this->skills()->pluck('name'),
            'contributors' => $this->freelancers->map(function ($freelancer) {
                return [
                    'profile' => $freelancer->profile,
                    'id' => $freelancer->id,
                ];
            }),
            'demo'=>$this->demo,
            'link'=>$this->link,
            'images'=>$this->images,
        ];
    }
}
