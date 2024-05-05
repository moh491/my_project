<?php

namespace App\Services;

use App\Http\Resources\CertificationResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use App\Models\Freelancer;

class WorkProfileService
{
    public function workProfile(string $id){
        $freelancer=Freelancer::find($id);
        $response =[
            'experiences'=>ExperienceResource::collection($freelancer->experiences),
            'educations'=>EducationResource::collection($freelancer->eductions),
            'certification'=>CertificationResource::collection($freelancer->certifications),
        ];
        return $response ;
    }
}
