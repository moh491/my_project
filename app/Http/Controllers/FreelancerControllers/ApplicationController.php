<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Services\ApplicationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function insert(StoreApplicationRequest $request )
    {
        try {
            $this->applicationService->applyForJob($request->validated());
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->applicationService->removeApplication($id);
            return $this->success('deleted successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function applicationOptions()
    {
        try {
            $options = $this->applicationService->getApplicationOptions();
            return $this->success('successfully',$options);
        }catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


    public function browseApplications(Request $request)
    {
        try {
            $freelancer_id = $request->query('freelancer_id');
            $applications = $this->applicationService->browseApplications($freelancer_id);
            return ApplicationResource::collection($applications);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function filterAll(Request $request)
    {
        try {
             $applications = $this->applicationService->filterAll($request->all());
            return $this->success('Successfully filtered applications.', $applications);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function getFreelancerApplications()
    {
        try {
             $freelancerId = Auth::guard('Freelancer')->user()->id;

             $applications = $this->applicationService->getFreelancerApplications($freelancerId);
            $data = ApplicationResource::collection($applications);

            return $this->success('Successfully retrieved applications.', $data);

        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }
    public function getCompanyApplications()
    {
        try {

            $companyId = Auth::guard('Company')->user()->id;

             $applications = $this->applicationService->getCompanyApplications($companyId);
            $data = ApplicationResource::collection($applications);

            return $this->success('Successfully retrieved applications.', $data);

        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

}
