<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Requests\SkillRequest;
use App\Services\SkillService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SkillController
{
    use ApiResponseTrait;
    public function insert(Request $request,string $id,SkillService $skillService){
        try {
            $validator = $request->all();
            $skillService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function delete(string $id,SkillService $skillService){
        try {
            $skillService->delete($id);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
