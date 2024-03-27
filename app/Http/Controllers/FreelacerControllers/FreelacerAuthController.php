<?php

namespace App\Http\Controllers\FreelacerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertUserRequest;
use App\Http\Requests\StoreFreelancerRequset;
use App\Models\Freelacer;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FreelacerAuthController extends Controller
{

use ApiResponseTrait;

    public function Register(StoreFreelancerRequset $request): \Illuminate\Http\JsonResponse
    {

        $request->validated($request->all());

        $Freelacer=Freelacer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        return $this->success([
            'message'=>'Register has successful',
            'freelancer'=>$Freelacer,
            'Token'=>$Freelacer->createToken('Api Token of ' . $Freelacer->name )->plainTextToken
        ]);

    }


}
