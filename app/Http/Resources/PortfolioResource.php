<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
                        'profile' => $freelancer->profile,
                        'id' => $freelancer->id,
                    ];
                })
                ->values(),
            'preview_image'=>$this->preview,
        ];
    }
}
