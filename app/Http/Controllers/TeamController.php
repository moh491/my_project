<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Http\Resources\ProjectReviewsResource;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Services\TeamService;
use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
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

            return $this->success('removeMember successful');
        } catch (\Throwable $throwable) {
            return response()->json(['error' => $throwable->getMessage()], 500);
        }
    }

    public function deleteTeam(Team $team){

            try {
                $freelancer = Auth::guard('Freelancer')->user();

                 $this->teamService->deleteTeam($freelancer, $team);

                return $this->success('Team deleted successfully');
            } catch (AuthorizationException $e) {
                return $this->error($e->getMessage());
            } catch (\throwable $throwable){
                return $this->serverError($throwable->getMessage());
            }
        }
        public function myTeams(){
        try {
            $freelancer = Auth::guard('Freelancer')->user();

            $teams = $this->teamService->getFreelancerTeams($freelancer);

            return $this->success( TeamResource::collection($teams));
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
          }
       }
       public function getTeamReviews(int $teamId){
        try {
             $reviews = $this->teamService->getTeamReviews($teamId);

             return $this->success(ProjectReviewsResource::collection($reviews));
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

}
