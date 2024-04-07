<?php

namespace App\Http\Controllers\FreelancerControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreFreelancerRequset;
 use App\Models\Freelancer;
use App\Traits\ApiResponseTrait;
 use Illuminate\Support\Facades\Hash;

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

        return $this->success([
            'message'=>'Register has successful',
            'freelancer'=>$Freelacer,
            'Token'=>$Freelacer->createToken('Api Token of ' . $Freelacer->name )->plainTextToken
        ]);

    }


}
