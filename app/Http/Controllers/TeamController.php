<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Models\Team;
use App\Services\TeamService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    use ApiResponseTrait;
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function store(StoreTeamRequest $request): JsonResponse
    {
        try {
            $freelancer = Auth::guard('Freelancer')->user();
            $this->authorize('create', Team::class);
             $this->teamService->createTeam($freelancer, $request);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }

    public function update(UpdateTeamRequest $request, Team $team): JsonResponse
    {
        try {
            $freelancer = Auth::guard('Freelancer')->user();
            $this->authorize('update', $team);

           $this->teamService->updateTeam($freelancer, $team, $request);
            return $this->success('updated successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }

    public function addMember(AddMemberRequest $request, Team $team): JsonResponse
    {
        try {
            $freelancer = Auth::guard('Freelancer')->user();
            $this->authorize('update', $team);

            $team = $this->teamService->addMember($team, $request);
            return $this->success('Add member successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }

    public function removeMember(RemoveMemberRequest $request, Team $team): JsonResponse
    {
        try {
            $freelancer = Auth::guard('Freelancer')->user();
            $this->authorize('update', $team);

            $team = $this->teamService->removeMember($team, $request);
            return $this->success('remove member successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
}
