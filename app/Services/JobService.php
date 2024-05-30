<?php

namespace App\Services;

use App\Filtering\FilterJob;
use App\Http\Resources\BrowseJobs;
use App\Models\Company;
use App\Models\Job;
use App\Models\Position;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\QueryBuilder\QueryBuilder;

class JobService
{
    use ApiResponseTrait;
    public function create(array $data): void
    {
        Job::create(
         $data
        );
    }

    public function update(string $id,array $data): void
    {
        $userId = auth()->guard('Company')->user();

        Job::where('id', $userId)->update($data);
    }

    public function delete(string $id): void
    {
        Job::where('id',$id)->delete();
    }

    public function getAllJobs()
    {
        return Job::paginate(10);
    }

    public function getJobById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return Job::with('company')->findOrFail($id);
    }

    #[ArrayShape(['companies' => "mixed", 'locations' => "\Illuminate\Support\Collection", 'salary_options' => "\Illuminate\Support\Collection", 'date_posted_options' => "mixed"])] public function getJobOptions()
    {
        $companies = Company::has('jobs')->select('id', 'name')->get();

        $locations = DB::table('companies')
            ->join('jobs', 'companies.id', '=', 'jobs.company_id')
            ->select('companies.location')
            ->distinct()
            ->get();

        $dates = Job::select(DB::raw('DATE(created_at) as date_posted'))
            ->distinct()
            ->get();

        $averageSalary = DB::table('jobs')
            ->select(DB::raw('((min_salary + max_salary) / 2) as average_salary'))
            ->distinct()
            ->get();

        foreach ($averageSalary as $salary) {
            $salary->average_salary = number_format($salary->average_salary, 0, '.', '');
        }

        return [
            'companies' => $companies,
            'locations' => $locations,
            'salary_options' => $averageSalary,
            'date_posted_options' => $dates,
        ];
    }

    public function filterAll(): AnonymousResourceCollection
    {
        $jobs = QueryBuilder::for(Job::class)
            ->allowedFilters((new FilterJob())->filterAll())
            ->with(['company:id,name,location'])
            ->get()
            ->makeHidden(['company_id']);

        return BrowseJobs::collection($jobs);
    }

}
