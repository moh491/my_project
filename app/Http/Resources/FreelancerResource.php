<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = [
            'id' => $this['id'],
            'profile' => app('baseUrl') . $this['profile'],
            'name' => $this['first_name'] . ' ' . $this['last_name']
        ];
        if ($request->routeIs('portfolio.show')) {
            return $array;
        }
        if ($request->routeIs('team.show')) {
            $array['full_name'] = $this->first_name . ' ' . $this->last_name;
            $array['position'] = [
                'id' => $this->position->id,
                'name' => $this->position->name,
            ];
            return $array;
        }

        return [
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'location' => $this->location,
            'position' => [
                'id' => $this->position->id,
                'name' => $this->position->name,
            ],
            'field' => [
                'id' => $this->position->field->id,
                'name' => $this->position->field->name,
            ],
            'time_zone' => $this->time_zone,
            'profile' => app('baseUrl') . $this->profile,
        ];
    }
}
