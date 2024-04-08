<?php

namespace App\Http\Controllers\CompanyControllers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\Auth\StoreCompanyrRequest;

class CompanyAuthController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreCompanyrRequest $request): JsonResponse
    {
        $validator = $request->validated();
        $validator['password'] = bcrypt($validator ['password']);
        $company = Company::create($validator );
        $success['token'] =  $company->createToken('auth-company-token',['role:Company'])->plainTextToken;
        $success['name'] =  $company->name;
        return $this->success('Register has successful for company',$success);
    }


}
