<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EndPointProjectOwnerResource;
use App\Models\Project_Owners;
use Illuminate\Http\Request;

class DashboardOwnerController extends Controller
{
    public function endPoint($id): EndPointProjectOwnerResource
    {
         $projectOwner = Project_Owners::with('projects')->findOrFail($id);

         return new EndPointProjectOwnerResource($projectOwner);
    }
}
