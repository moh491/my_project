<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreProjectOwnersRequset;
 use App\Models\Project_Owners;
use App\Traits\ApiResponseTrait;
 use Illuminate\Support\Facades\Hash;

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

        return $this->success([
            'message'=>'Register has successful',
            'freelancer'=>$project_owner,
            'Token'=>$project_owner->createToken('Api Token of ' . $project_owner->name )->plainTextToken
        ]);

    }

}
