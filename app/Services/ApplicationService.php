<?php

namespace App\Services;

use App\Filtering\FilterApplication;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\appResource;
use App\Http\Resources\OfferResource;
use App\Mail\SentMail;
use App\Models\Application;
use App\Models\Company;
use App\Models\CompanyJob;
use App\Models\Freelancer;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ApplicationService
{
    use ApiResponseTrait;

    public function applyForJob($data)
    {
        $application=Application::create([
            'job_id'=>$data['job_id'],
            'freelancer_id'=>Auth::guard('Freelancer')->user()->id,
            'budget'=>$data['budget'],
            'experience_year'=>$data['experience_year'],
        ]);
        if (isset($data['file'])) {
            $fileName = Str::uuid() . '.' . $data['file']->getClientOriginalExtension();
            $path = $data['file']->storeAs('Application', $fileName, 'public');
            $application->update(['file' => $path]);
        }
    }
    public function changetoReviewed($id){
        $application=Application::find($id);
        $application->update(['status'=>'reviewed']);
    }
    public function Accept($id){
        $application=Application::find($id);
        $job=CompanyJob::find($application['job_id']);
        $company=Company::find($job['company_id']);
        $freelancer=Freelancer::find($application['freelancer_id']);
        $application->update(['status'=>'accepted']);
        //mail to freelancer
        $description = $company->name . ' has accepted the application for the job ' . $job->title . ' To contact the company via e-mail: '.$company->email;
        $title = 'Accept application';
        Mail::to($freelancer->email)->send(new SentMail($title, $description));

        //mail to company
        $title='Send the freelancer email that you agree to application';
        $description='You can contact the freelancer via e-mail: '.$freelancer->email.' in order to request a job opportunity '.$job->title;
        Mail::to($company->email)->send(new SentMail($title,$description));


    }
    public function Reject($id){
        $application=Application::find($id);
        $job=CompanyJob::find($application['job_id']);
        $company=Company::find($job['company_id']);
        $freelancer=Freelancer::find($application['freelancer_id']);
        $application->update(['status'=>'rejected']);
        //mail to freelancer
        $description = $company->name . ' has rejected the application for the job ' . $job->title ;
        $title = 'Reject application';
        Mail::to($freelancer->email)->send(new SentMail($title, $description));

    }
    public function filterOfApplication($jobId){
        $job=CompanyJob::find($jobId);
        $application = $job->applications();
        $app = QueryBuilder::for($application)
            ->allowedFilters([
                AllowedFilter::exact('experience_year'),
                AllowedFilter::exact('budget'),
            ])
            ->orderBy('created_at','desc')->get();
        return appResource::collection($app);

    }
    public function removeApplication($id): void
    {
        $application = Application::findOrFail($id);
        $application->delete();
    }

    public function browseApplications($freelancer_id)
    {
        return Application::where('freelancer_id', $freelancer_id)->orderBy('created_at','desc')->get();
    }

    public function filterAll()
    {

        $applications = QueryBuilder::for(Application::class)
            ->allowedFilters((new FilterApplication())->filterAll())->orderBy('created_at','desc')
            ->get();

        return OfferResource::collection($applications);

    }

    public function getApplicationOptions()
    {

    }


    public function getFreelancerApplications(int $freelancerId)
    {
        $freelancer = Freelancer::findOrFail($freelancerId);
        return $freelancer->applications()
            ->with('job')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCompanyApplications(int $companyId)
    {
        $company = Company::findOrFail($companyId);
        return $company->jobs()
            ->with(['applications' => function($query) {
                $query->orderBy('created_at', 'desc');
            }, 'applications.freelancer'])
            ->get()
            ->flatMap(function ($job) {
                return $job->applications;
            });
    }

}
