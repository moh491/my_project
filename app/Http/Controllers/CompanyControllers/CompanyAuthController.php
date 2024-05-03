<?php

namespace App\Http\Controllers\CompanyControllers;
use App\Http\Controllers\Controller;
use App\Mail\SendCodeEmail;
use App\Models\Company;
use App\Models\Otp;
use App\Models\User;
use App\Services\CompanyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\Auth\StoreCompanyrRequest;

class CompanyAuthController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreCompanyrRequest $request,CompanyService $companyService): JsonResponse
    {
        try {

            $validator = $request->validated();
            $company = $companyService->createCompany($validator);
            return $this->success('Register has successful',$company);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
}
