<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->title,
            'description'=>$this->description,
            'image'=>$this->image,
            'plans' => $this->plans->map(function ($plan) {
                return [
                    'type' => $plan->type,
                    'price' => $plan->price,
                    'description'=>$plan->description,
                    'features'=>$plan->features->map(function ($feature){
                    return [
                        'name'=>$feature->name,
                        'is_boolean'=>$feature->is_boolean,
                        'value'=>$feature->pivot['value'],
                    ];
                    }),
                    'delivery_options'=>$plan->delivery_options->map(function ($delivery){
                        return [
                            'days'=>$delivery->days,
                            'increase'=>$delivery->increase,
                        ];
                    })
                ];
            }),




        ];
    }
}
