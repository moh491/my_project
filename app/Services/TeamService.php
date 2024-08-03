<?php
namespace App\Services;

use App\Http\Resources\ProfilePageTeamResource;
use App\Models\Freelancer;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamService
{

    public function ProfilePage($id): ProfilePageTeamResource
    {
        $team = Team::find($id);
        return new ProfilePageTeamResource($team);
    }

    public function createTeam(Freelancer $freelancer, Request $request)
    {
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $team = Team::create($data);
        $team->freelancers()->attach($freelancer->id, ['position_id' => $request->position_id]);
        return $team;
    }

    public function updateTeam(Freelancer $freelancer, Team $team, Request $request)
    {
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $team->update($data);
        return $team;
    }

    public function addMember(Team $team, Request $request)
    {
        $team->freelancers()->attach($request->freelancer_id, ['position_id' => $request->position_id]);
        return $team;
    }

    public function removeMember(Team $team, $freelancerId): void
    {
        $team->freelancers()->detach($freelancerId);
    }

}
