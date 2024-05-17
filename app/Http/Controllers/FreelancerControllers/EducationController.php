<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Services\EducationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    use ApiResponseTrait;
    public function insert(EducationRequest $request,EducationService $educationService){
        try {
            $validator = $request->validated();
            $id = Auth::user()->id;
            $educationService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function update(Request $request,string $id,EducationService $educationService){
        try {
            $data = $request->all();
            $educationService->update($id,$data);
            return $this->success('updated successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id,EducationService $educationService){
        try {
            $educationService->delete($id);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
