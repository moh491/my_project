<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\CompanyJob;
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

    public function insert(StoreApplicationRequest $request)
    {
        try {
            $data = $request->validated();
            if (Auth::guard('Freelancer')->user()) {
                $this->applicationService->applyForJob($data);
                return $this->success('insert successful');
            } else {
                $this->error(' You dont have the authority');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function ChangeStatusToReviewed($id)
    {
        try {
            $application = Application::find($id);
            $job = CompanyJob::find($application['job_id']);
            if ($job['company_id'] == Auth::guard('Company')->user()->id) {
                $this->applicationService->changetoReviewed($id);
                return $this->success('change successfully');
            } else {
                return $this->error(' You dont have the authority');
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function Accept($id)
    {

        try {
            $application = Application::find($id);
            $job = CompanyJob::find($application['job_id']);
            if ($job['company_id'] == Auth::guard('Company')->user()->id) {
                $this->applicationService->Accept($id);
                return $this->success('Accept successfully');
            } else {
                return $this->error(' You dont have the authority');
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function Reject($id)
    {
        try {
            $application = Application::find($id);
            $job = CompanyJob::find($application['job_id']);
            if ($job['company_id'] == Auth::guard('Company')->user()->id) {
                $this->applicationService->Reject($id);
                return $this->success('Reject successfully');
            } else {
                return $this->error(' You dont have the authority');
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function filterOfApplication($jobId)
    {
        try {
            $id = Auth::guard('Company')->user()->id;
            $job = CompanyJob::find($jobId);
            if ($job['company_id'] == $id) {
                $application = $this->applicationService->filterOfApplication($jobId);
                return $this->success('filter successfully', $application);
            }


        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }


    }


    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $application = Application::find($id);
            if ($application['freelancer_id'] == Auth::guard('Freelancer')->user()->id) {
                if ($application['status'] == 'pending' || $application['status'] == 'rejected') {
                    $this->applicationService->removeApplication($id);
                    return $this->success('deleted successfully');
                } else {
                    return $this->error('You cant delete the application');
                }
            } else {
                return $this->error('You dont have the authority');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function applicationOptions()
    {
        try {
            $options = $this->applicationService->getApplicationOptions();
            return $this->success('successfully', $options);
        } catch (\throwable $throwable) {
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
            $applications = $this->applicationService->filterAll();
            return $this->success('successfully', $applications);
        } catch (\throwable $throwable) {
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
