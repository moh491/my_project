<?php

namespace App\Http\Controllers\CompanyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCompanyBrofileRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use ApiResponseTrait;

    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        try {
            $companies = Company::all();
            return $this->success('get company', CompanyResource::collection($companies));
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getProfile()
    {
        try {
             $company = Auth::guard('Company')->user();

            if (!$company) {
                return $this->error('user not authenticated');
            }
            $data = $this->companyService->getProfile($company->id);

            return $this->success('Get company profile', $data);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getCompanyProfile($id)
    {
        try {
            $data = $this->companyService->getCompanyProfile($id);
            return $this->success('Get company profile', $data);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }
    public function update(UpdateCompanyBrofileRequest $request)
    {
        try {
            $company = Auth::guard('Company')->user();

            $this->companyService->updateCompany($company, $request->validated());

            return $this->success('updated successful');
        }  catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
