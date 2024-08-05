<?php

namespace App\Http\Controllers\CompanyControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

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

    public function getProfile($id)
    {
        try {
            $data = $this->companyService->getCompanyProfile($id);
            return $this->success('Get company profile', $data);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

}
