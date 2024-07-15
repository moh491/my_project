<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this['id'],
            'note'=>$this['note'],
            'files'=>app('baseUrl').$this['files'],
            'budget'=>$this['budget'],
            'status'=>$this['status'],
            'rating'=>$this['rating'],
            'project_owner_id'=>$this['project_owner_id'],
            'delivery_option_id'=>$this['delivery_option_id']
        ];
    }
}
