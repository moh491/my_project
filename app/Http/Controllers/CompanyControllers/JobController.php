<?php

namespace App\Http\Controllers\CompanyControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Http\Resources\BrowseJobs;
use App\Http\Resources\JobResource;
use App\Models\Company;
use App\Services\JobService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


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
            $validator['company_id']=auth()->guard('Company')->user()->id;
            $company=Company::find($validator['company_id']);
            if($company->withdrawal_balance >= 5 ) {
                $this->jobService->create($validator);
                return $this->success('insert successful');
            }
            else{
                return $this->error('Please recharge the balance before create job');
            }
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

    public function browseJobs(): \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse|AnonymousResourceCollection
    {
        try {
            $jobs = BrowseJobs::collection($this->jobService->getAllJobs()) ;
            return $this->success('Get jobs successfully',$jobs);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function jobDetails($id)
    {
        try {
            $job = $this->jobService->getJobById($id);
            return new JobResource($job);

        }catch (\Throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getJobOptions()
    {
        try {
             $options = $this->jobService->getJobOptions();
            return $this->success('successfully',$options);
        }catch (\throwable $throwable){
                return $this->serverError($throwable->getMessage());
            }
    }

    public function filterAll(Request $request)
    {
        try {
            $jobs = $this->jobService->filterAll();
            return $this->success('success',$jobs);
        } catch  (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
