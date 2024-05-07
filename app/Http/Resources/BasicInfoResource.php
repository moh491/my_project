<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'about'=>$this->about,
            'languages'=>$this->languages()->select('language', 'level')->get(),
            'skills'=>$this->skills()->pluck('name'),
        ];
    }
}
