<?php

namespace App\Policies;

use App\Models\Freelancer;
use App\Models\Owner_Portfolio;
use App\Models\Portfolio;
use App\Models\Team;
use App\Models\User;

class PortfloioPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function access(Freelancer $freelancer, Portfolio $portfolio)
    {
        $owner = Owner_Portfolio::where('portfolio_id', $portfolio->id)->first();
        if ($owner->owner_type == Team::class) {
            $team = Team::find($owner->owner_id);
            // Check if the authenticated freelancer is a member of the team
            return $this->isMemberOfTeam($freelancer,$team);
        } else {
            // Check if the authenticated freelancer  owns the portfolio
            return $freelancer->portfolios()->where('portfolio_id', $portfolio->id)->exists();
        }
    }
    public function isMemberOfTeam(Freelancer $freelancer,Team $team){
        return $team->freelancers->contains($freelancer->id);
    }
}
