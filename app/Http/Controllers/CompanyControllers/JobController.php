<?php

namespace App\Http\Controllers\CompanyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Services\JobService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class JobController extends Controller
{
   use ApiResponseTrait;

    protected  $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }
    public function insert(JobRequest $request ): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = $request->validated();
            $validator['company_id']=auth()->user()->id;
            $this->jobService->create($validator);
            return $this->success('insert successful');
        }
            catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }

    public function update(Request $request,string $id){
        try {
            $this->jobService->update($id, $request->all());
            return $this->success('updated successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->jobService->delete($id);
            return $this->success('deleted successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function browseJobs(){


    }
//
//    public function store(JobRequest $request)
//    {
//        return (new JobService())->store($request);
//    }
}
