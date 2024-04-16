<?php

namespace App\Http\Controllers\FreelancerControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreFreelancerRequset;
use App\Mail\SendCodeEmail;
use App\Models\Freelancer;
use App\Models\Otp;
use App\Traits\ApiResponseTrait;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FreelancerAuthController extends Controller
{

use ApiResponseTrait;

    public function register(StoreFreelancerRequset $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());

        $Freelacer=Freelancer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'field_id'=>$request->field_id,
            'position_id'=>$request->position_id,
            'about'=>$request->about,
            ]);
        $code = mt_rand(100000, 999999);
        while(Otp::where('otp', $code)->exists()){
            $code = mt_rand(100000, 999999);
        }
        Otp::create([
            'otpable_id'=>$Freelacer->id,
            'otpable_type'=>'App\\Models\\Freelancer',
            'otp'=>$code,
            'otp_expiry_time'=>now()->addMinute(15),
        ]);
        Mail::to($Freelacer->email)->send(new SendCodeEmail($code));
        return $this->success([
            'message'=>'Register has successful',
            'freelancer'=>$Freelacer,
            'Token'=>$Freelacer->createToken('Api Token of ' . $Freelacer->name )->plainTextToken
        ]);

    }


}
