<?php

namespace App\Http\Controllers\FreelancerControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFreelancerRequest;
use App\Http\Requests\StoreFreelancerRequset;
use App\Models\Freelancer;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FreelancerAuthController extends Controller
{

use ApiResponseTrait;

    public function Register(StoreFreelancerRequset $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());

        $Freelacer=Freelancer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'about'=>$request->about,
            ]);

        return $this->success([
            'message'=>'Register has successful',
            'freelancer'=>$Freelacer,
            'Token'=>$Freelacer->createToken('Api Token of ' . $Freelacer->name )->plainTextToken
        ]);

    }

    public function Login(LoginFreelancerRequest $request){

        $request->validated($request->all());

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->error('Invalid email or password. Please check your credentials.', 401);
        }

    }

    public function Logout(): \Illuminate\Http\JsonResponse
    {

        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>'1',
            'data'=>[], 'message'=>'user logout successfully'
        ]);

    }
}
