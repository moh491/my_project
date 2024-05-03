<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreProjectOwnersRequset;
use App\Mail\SendCodeEmail;
use App\Models\Otp;
use App\Models\Project_Owners;
use App\Services\ProjectOwnerService;
use App\Traits\ApiResponseTrait;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProjectOwnersAuthController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreProjectOwnersRequset $request,ProjectOwnerService $projectOwnerService): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = $request->validated();
            $projectOwner = $projectOwnerService->createProjectOwner($validator);
            return $this->success('Register has successful',$projectOwner);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }

}
