<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class appResource extends JsonResource
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
            'freelancer' => [
                'id' => $this->freelancer->id,
                'name'=>$this->freelancer->first_name.' '.$this->freelancer->last_name,
                'profile'=>app('baseUrl') .$this->freelancer->profile,
                'about'=>$this->freelancer->about,
            ],
        ];
    }
}
