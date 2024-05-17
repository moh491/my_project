<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceRequest;
use App\Services\ExperiencService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    use ApiResponseTrait;
    public function insert(ExperienceRequest $request,ExperiencService $experiencService){
        try {
            $validator = $request->validated();
            $id = Auth::user()->id;
            $experiencService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function update(Request $request,string $id,ExperiencService $experiencService){
        try {
            $data = $request->all();
            $experiencService->update($id,$data);
            return $this->success('updated successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id,ExperiencService $experiencService){
        try {
            $experiencService->delete($id);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
