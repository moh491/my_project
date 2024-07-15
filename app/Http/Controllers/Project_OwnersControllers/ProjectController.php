<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectDetialsResource;
use App\Http\Resources\ProjectResource;
use App\Models\Request;
use App\Services\ProjectService;
use App\Traits\ApiResponseTrait;

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
            $this->projectService->createProject($request);
            return $this->success('insert has been successfully');
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
