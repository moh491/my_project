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

    public function getProfilePage($id): JsonResponse
    {
        try {
            $information = $this->teamService->ProfilePage($id);
            return $this->success('get Profile Page',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function store(StoreTeamRequest $request)
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

    public function update(UpdateTeamRequest $request, Team $team)
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

    public function addMember(AddMemberRequest $request, Team $team)
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

    public function removeMember(RemoveMemberRequest $request, Team $team)
    {
        try {

            $freelancer = Auth::guard('Freelancer')->user();
            $this->authorize('update', $team);

            $this->teamService->removeMember($team, $request->freelancer_id);

            return response()->json(['message' => 'Member removed successfully'], 200);
        } catch (\Throwable $throwable) {
            return response()->json(['error' => $throwable->getMessage()], 500);
        }
    }
}
