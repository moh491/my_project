<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Services\SkillService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends controller
{
    use ApiResponseTrait;
    public function insert(Request $request,SkillService $skillService,$id=null){
        try {
            if($id){
                $type='App\\Models\\Team';
            }
            else{
                $type='App\\Models\\Freelancer';
                $id=Auth::user()->id;
            }
            $validator = $request->all();
            $skillService->create($id,$type,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function delete(string $skillId,SkillService $skillService,$id=null){
        try {
            if($id){
                $type='App\\Models\\Team';
            }
            else{
                $type='App\\Models\\Freelancer';
                $id=Auth::user()->id;
            }
            $skillService->delete($skillId,$id,$type);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
