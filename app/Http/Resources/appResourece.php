<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class appResourece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'status' => $this->status,
            'budget' => $this->budget,
            'experience_year' => $this->experience_year,
            'file' =>app('baseUrl') .  $this->file,
        ];
    }
}
