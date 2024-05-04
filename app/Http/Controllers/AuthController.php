<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\userForgotPasswordRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\Company;
use App\Models\Freelancer;
use App\Models\Otp;
use App\Models\Portfolio;
use App\Models\Project_Owners;
use App\Models\ResetCodePassword;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Team;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login (LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        if (!Auth::guard($data['user_type'])->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return $this->error(['message' => 'invalid credentials']);
        }
        $user = Auth::guard($data['user_type'])->user();
        if(!$user->email_verified_at){
            return $this->error('Please verified your email to allow login');
        }
        $token = $user->createToken('auth_' . $data['user_type'] . '_ token', ['*'])->plainTextToken;
        return $this->success('login successful', $user, $token);
    }


    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $user=$request->user();
        $user->tokens()->delete();
        return $this->success('user logout successfully');
    }

    public function verifyOtp(VerifyOtpRequest $request){
        $data = $request->validated();
        $otps = Otp::where('otp',$data['otp'])->first();
        if(!$otps || $otps->otp_expiry_time < now()){
            return $this->error('Invalid OTP');
        }
        switch($otps->otpable_type){
            case'App\\Models\\Company':
                Company::where('email',$data['email'])->update(['email_verified_at'=>now()]);
                break;
            case'App\\Models\\Freelancer':
                Freelancer::where('email',$data['email'])->update(['email_verified_at'=>now()]);
                break;
            case'App\\Models\\Project_Owners':
                Project_Owners::where('email',$data['email'])->update(['email_verified_at'=>now()]);
                break;
        }
        return $this->success('Verified successfully');
    }

    public function userForgotPassword(userForgotPasswordRequest $request){
        $data = $request->validated();
        $data['code'] = mt_rand(100000, 999999);
        $codeData = ResetCodePassword::create($data);
        Mail::to($data['email'])->send(new SendCodeResetPassword($data['code']));
        return $this->success('code sent');
    }

    public function userResetPassword(UserResetPasswordRequest $request){
        $data = $request->validated();
        $passwordReset = ResetCodePassword::firstWhere('code', $data['code']);
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete()    ;
            return $this->error('passwords.code_is_expire');
        }
        switch ($data['role']){
            case'Company':
                Company::where('email',$data['email'])->update(['password'=>bcrypt($data['password'])]);
                break;
            case'Freelancer':
                Freelancer::where('email',$data['email'])->update(['password'=>bcrypt($data['password'])]);
                break;
            case'Project_Owners':
                Project_Owners::where('email',$data['email'])->update(['password'=>bcrypt($data['password'])]);
                break;
        }
        $passwordReset->delete();
        return $this->success('password has been successfully reset');
    }






}
