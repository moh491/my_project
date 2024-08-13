<?php

namespace App\Services;

use App\Filtering\FilterApplication;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\OfferResource;
use App\Models\Application;
use App\Models\Company;
use App\Models\Freelancer;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ApplicationService
{
    use ApiResponseTrait;

    public function applyForJob(StoreApplicationRequest $request)
    {
        return Application::create($request->all());
    }

    public function removeApplication($id): void
    {
        $application = Application::findOrFail($id);
        $application->delete();
    }

    public function browseApplications($freelancer_id)
    {
        return Application::where('freelancer_id', $freelancer_id)->get();
    }

    public function filterAll(array $filters)
    {
         $companyId = Auth::guard('Company')->id();

        $query = QueryBuilder::for(Application::class)
            ->whereHas('job', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->allowedFilters((new FilterApplication())->filterAll());

         $applications = $query->get();

        return ApplicationResource::collection($applications);
    }

    public function getApplicationOptions()
    {

    }


    public function getFreelancerApplications(int $freelancerId)
    {
        $freelancer = Freelancer::findOrFail($freelancerId);
        return $freelancer->applications()->with('job')->get();
    }

    public function getCompanyApplications(int $companyId)
    {
        $company = Company::findOrFail($companyId);
        return $company->jobs()->with('applications.freelancer')->get()->flatMap(function ($job) {
            return $job->applications;
        });
    }

}
