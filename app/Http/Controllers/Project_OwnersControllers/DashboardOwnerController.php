<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProjectOwnerRequest;
use App\Http\Resources\EndPointProjectOwnerResource;
use App\Models\Project_Owners;
use App\Services\ProjectOwnerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardOwnerController extends Controller
{
use ApiResponseTrait;
    public function __construct(ProjectOwnerService $projectOwnerService)
    {
        $this->projectOwnerService = $projectOwnerService;
    }

    public function endPoint($id=null)
    {
        if(!$id){
            $id = Auth::guard('Project_Owner')->user()->id;
        }
         $projectOwner = Project_Owners::with('projects')->findOrFail($id);

         return new EndPointProjectOwnerResource($projectOwner);
    }

    public function update(UpdateProjectOwnerRequest $request)
    {
        try {
             $projectOwner = Auth::guard('Project_Owner')->user();

             $this->projectOwnerService->updateProjectOwner($projectOwner, $request->validated());

            return $this->success('updated successful');
        }  catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
