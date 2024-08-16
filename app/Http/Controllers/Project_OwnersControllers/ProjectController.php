<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectReviewRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectDetialsResource;
use App\Http\Resources\ProjectResource;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Project_Owners;
use App\Models\Request;
use App\Models\Team;
use App\Services\ProjectService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    use ApiResponseTrait;

    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function store(StoreProjectRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $id = Auth::guard('Project_Owner')->user()->id;
            $projectOwner = Project_Owners::find($id);
            if ($projectOwner->withdrawal_balance < $data['max_budget']) {
                return $this->error('Please recharge before republishing the project');
            }
            $this->projectService->createProject($data, $id);
            return $this->success('insert has been successfully');
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }


    public function delivery($id)
    {
        try {
            $project = Project::find($id);
            if (($project['worker_type'] == 'App\\Models\\Freelancer' && $project['worker_id'] == Auth::guard('Freelancer')->user()->id) || ($project['worker_type'] == 'App\\Models\\Team' && Team::find($project['worker_id'])->freelancers->contains(Auth::guard('Freelancer')->user()->id))) {
                $this->projectService->Projectdelivery($id);
                return $this->success('delivery Successfully');
            } else {
                return $this->error('not authorized');
            }

        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }


    }

    public function Accept($id)
    {
        try {
            $offer = Offer::find($id);
            $project = Project::find($offer['project_id']);
            if ($project['project_owner_id'] ==Auth::guard('Project_Owner')->user()->id) {
                $this->projectService->AcceptProject($id);
                return redirect('http://localhost:5173/addRating/' . $project['id']);
            } else {
                return $this->error('not authorized');
            }
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }


    }

    public function rating(ProjectReviewRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $project = Project::find($id);
            if ($project['project_owner_id'] == Auth::guard('Project_Owner')->user()->id) {
                $this->projectService->rating($data, $id);
                return $this->success('rating Successfully');
            } else {
                return $this->error('not authorized');
            }
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function projectDetails($id)
    {
        try {
            $project = $this->projectService->getProjectById($id);
            return $this->success('GEt project details', new ProjectDetialsResource($project));

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function projectOptions(): \Illuminate\Http\JsonResponse
    {
        try {
            $options = $this->projectService->getProjcetOptions();
            return $this->success('successfully', $options);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function browseProjects(): \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        try {
            $projects = ProjectResource::collection($this->projectService->getAllProjects());
            return $this->success('Get projects successfully', $projects);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function filterAll(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $projects = $this->projectService->filterAll();
            return $this->success('success', $projects);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

}
