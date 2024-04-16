<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreProjectOwnersRequset;
use App\Mail\SendCodeEmail;
use App\Models\Otp;
use App\Models\Project_Owners;
use App\Traits\ApiResponseTrait;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProjectOwnersAuthController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreProjectOwnersRequset $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());

        $project_owner=Project_Owners::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'field_id'=>$request->field_id,
            'about'=>$request->about,
        ]);
        $code = mt_rand(100000, 999999);
        while(Otp::where('otp', $code)->exists()){
            $code = mt_rand(100000, 999999);
        }
        Otp::create([
            'otpable_id'=>$project_owner->id,
            'otpable_type'=>'App\\Models\\Project_Owners',
            'otp'=>$code,
            'otp_expiry_time'=>now()->addMinute(15),
        ]);
        Mail::to($project_owner->email)->send(new SendCodeEmail($code));
        return $this->success([
            'message'=>'Register has successful',
            'freelancer'=>$project_owner,
            'Token'=>$project_owner->createToken('Api Token of ' . $project_owner->name )->plainTextToken
        ]);

    }

}
