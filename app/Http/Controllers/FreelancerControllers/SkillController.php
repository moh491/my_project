<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use App\Models\Team;
use App\Services\SkillService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends controller
{
    use ApiResponseTrait;

    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $skills = Skill::all();
            return $this->success('get skills', SkillResource::collection($skills));
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function insert(Request $request, $id = null)
    {
        try {
            if ($id) {
                $type = 'App\\Models\\Team';

            } else {
                $type = 'App\\Models\\Freelancer';
                $id = Auth::guard('Freelancer')->user()->id;
            }
            if ($type == 'App\\Models\\Team') {
                $team = Team::find($id);
                if (!Auth::guard('Freelancer')->user()->can('isMemberOfTeam', [Skill::class, $team])) {
                    return $this->error('not authorized');
                }
            }
            $validator = $request->all();
            $this->skillService->create($id, $type, $validator);
            return $this->success('insert successful');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $skillId, $id = null)
    {
        try {
            if ($id) {
                $type = 'App\\Models\\Team';
            } else {
                $type = 'App\\Models\\Freelancer';
                $id = Auth::guard('Freelancer')->user()->id;
            }
            if ($type == 'App\\Models\\Team') {
                $team = Team::find($id);
                if (!Auth::guard('Freelancer')->user()->can('isMemberOfTeam', [Skill::class, $team])) {
                    return $this->error('not authorized');
                }
            }
            $this->skillService->delete($skillId, $id, $type);
            return $this->success('deleted successful');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


}
