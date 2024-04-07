<?php

namespace App\Http\Controllers\CompanyControllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreCompanyrRequest;
 use App\Models\Company;
use App\Traits\ApiResponseTrait;
 use Illuminate\Http\JsonResponse;


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

        return $this->success('Register has successful',$success);
    }

}
