<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceRequest;
use App\Http\Requests\ExperienceUpdateRequest;
use App\Models\Experience;
use App\Services\ExperiencService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    use ApiResponseTrait;

    protected $experiencService;

    public function __construct(ExperiencService $experiencService)
    {
        $this->experiencService = $experiencService;
    }

    public function index($id)
    {
     $experience=Experience::find($id);
     return $this->success('get experience',$experience);
    }

    public function insert(ExperienceRequest $request)
    {
        try {
            $validator = $request->validated();
            $id = Auth::guard('Freelancer')->user()->id;
            $this->experiencService->create($id, $validator);
            return $this->success('insert successful');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function update(ExperienceUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $experience = Experience::find($id);
            if (Auth::guard('Freelancer')->user()->can('access', [Experience::class, $experience])) {
                $this->experiencService->update($id, $data);
                return $this->success('updated successful');
            } else {
                return $this->error('not authorized');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $experience = Experience::find($id);
            if (Auth::guard('Freelancer')->user()->can('access', [Experience::class, $experience])) {
                $this->experiencService->delete($id);
                return $this->success('deleted successful');
            } else {
                return $this->error('not authorized');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

}
