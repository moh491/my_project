<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public $dur = '';

    public function calculateDuration($end_date, $start_date)
    {
        $duration = (new DateTime($end_date))->diff(new DateTime($start_date));
        $years = $duration->y;
        $months = $duration->m;

        $dur = '';
        if ($years > 0) {
            $dur .= $years . ' yr ';
        }
        if ($months > 0) {
            $dur .= $months . ' mos';
        }

        return trim($dur);
    }

    public function toArray(Request $request): array
    {


        return [
            'id' => $this->id,
            'position' => $this->position->name,
            'company' => $this->when($this->company, function () {
                return [
                    'id' => $this->company->id,
                    'name' => $this->company->name,
                    'logo' => $this->company->logo,
                ];
            }, [
                'name' => $this->company_name
            ]),
            'duration' => $this->end_date ? $this->calculateDuration($this->start_date, $this->end_date) : 'present',
            'employment_type' => $this->employment_type,
            'location_type' => $this->location_type,
            'location' => $this->location,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
        ];

    }
}
