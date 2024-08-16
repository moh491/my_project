<?php

namespace App\Services;

use App\Filtering\FilterJob;
use App\Http\Resources\BrowseJobs;
use App\Models\Company;
use App\Models\CompanyJob;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class JobService
{
    use ApiResponseTrait;
    public function create(array $data): void
    {
        CompanyJob::create($data);
        $company=Company::find($data['company_id']);
        $company->update(['withdrawal_balance'=>$company['withdrawal_balance']-5]);
    }

    public function update(string $id,array $data): void
    {
        $userId = auth()->guard('Company')->user();

        CompanyJob::where('id', $userId)->update($data);
    }

    public function delete(string $id): void
    {
        CompanyJob::where('id',$id)->delete();
    }

    public function getAllJobs()
    {
        return CompanyJob::orderBy('created_at', 'desc')->paginate(2);
    }

    public function getJobById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return CompanyJob::with('company')->findOrFail($id);
    }

     public function getJobOptions(): array
     {
        $companies = Company::has('jobs')->select('id', 'name')->get();

        $locations = DB::table('companies')
            ->join('company_jobs', 'companies.id', '=', 'company_jobs.company_id')
            ->select('companies.location')
            ->distinct()
            ->get();


         $salaries = [];
         $maxSalary = ceil(CompanyJob::max('max_salary'));
         $minSalary = floor(CompanyJob::min('min_salary'));
         for ($i = $minSalary; $i <= $maxSalary; $i += 100) {
             $salaries [] = $i . '-' . $i + 99;
         }


        return [
            'companies' => $companies,
            'locations' => $locations->pluck('location'),
            'salary_options' => $salaries,
        ];
    }

    public function filterAll()
    {
        $jobs = QueryBuilder::for(CompanyJob::class)
            ->allowedFilters((new FilterJob())->filterAll())
            ->with(['company:id,name,location'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->makeHidden(['company_id']);
        return BrowseJobs::collection($jobs);
    }

}
