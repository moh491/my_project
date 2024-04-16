<?php

namespace App\Http\Controllers\CompanyControllers;
use App\Http\Controllers\Controller;
use App\Mail\SendCodeEmail;
use App\Models\Company;
use App\Models\Otp;
use App\Models\User;
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

    public function register(StoreCompanyrRequest $request): JsonResponse
    {
        $validator = $request->validated();
        $validator['password'] = bcrypt($validator ['password']);
        $company = Company::create($validator );
        $success['token'] =  $company->createToken('auth-company-token',['role:Company'])->plainTextToken;
        $success['name'] =  $company->name;
        $code = mt_rand(100000, 999999);
        while(Otp::where('otp', $code)->exists()){
            $code = mt_rand(100000, 999999);
        }
        Otp::create([
            'otpable_id'=>$company->id,
            'otpable_type'=>'App\\Models\\Company',
            'otp'=>$code,
            'otp_expiry_time'=>now()->addMinute(15),
        ]);
        Mail::to($company->email)->send(new SendCodeEmail($code));
        return $this->success('Register has successful for company',$success);
    }
}
