<?php

namespace App\Services;

use App\Http\Resources\FieldResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\SkillResource;
use App\Models\Field;
use App\Models\Position;
use App\Models\Skill;

class DataServices
{
public function get(){
  $skill=  Skill::all();
  $positions=Position::all();
  $fields=Field::all();
    $response =[
        'skills'=>SkillResource::collection($skill),
        'positions'=>PositionResource::collection($positions),
        'fields'=>FieldResource::collection($fields),
    ];
    return $response;
}
}
