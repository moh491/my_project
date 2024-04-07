<?php

namespace App\Http\Controllers\CompanyControllers;


use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\loginCompanyRequest;
use App\Http\Requests\StoreCompanyrRequest;
use App\Http\Requests\StoreCompanyrRequset;
use App\Models\Company;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Cassandra\Exception\AuthenticationException;
use Cassandra\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
=======
use App\Http\Requests\Auth\StoreCompanyrRequest;
 use App\Models\Company;
use App\Traits\ApiResponseTrait;
 use Illuminate\Http\JsonResponse;
>>>>>>> mohamed


class CompanyAuthController extends Controller
{
    use ApiResponseTrait;
<<<<<<< HEAD
=======

    public function register(StoreCompanyrRequest $request): JsonResponse
    {
        $validator = $request->validated();
        $validator['password'] = bcrypt($validator ['password']);
        $company = Company::create($validator );
        $success['token'] =  $company->createToken('auth-company-token',['role:Company'])->plainTextToken;
        $success['name'] =  $company->name;

        return $this->success('Register has successful',$success);
    }
>>>>>>> mohamed


    public function register(StoreCompanyrRequest $request): JsonResponse
    {
        $validator = $request->validated();
        $validator['password'] = bcrypt($validator ['password']);
        $company = Company::create($validator );
        $success['token'] =  $company->createToken('auth-company-token',['role:Company'])->plainTextToken;
        $success['name'] =  $company->name;
        return $this->success('Register has successful',$success);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(loginCompanyRequest $request): JsonResponse
    {
        $data = $request->validated();
        if(!Auth::guard('Company')->attempt(['email' => $data['email'], 'password' => $data['password']])){
            return $this->error(['message' => 'invalid credentials']);
        }
        $company = Auth::guard('Company')->user();
        $token = $company->createToken('auth-company-token', ['*'])->plainTextToken;
        return $this->success('login successful',['token' => $token, 'company' => $company->name]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->success('Logout Successful');
    }
}
