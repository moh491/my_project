<?php

namespace App\Policies;

use App\Models\Freelancer;
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
    public function update(Freelancer $freelancer,  Portfolio $portfolio, ?int $teamId = null)
    {
        if (is_null($teamId)) {
            // Check if the freelancer owns the portfolio
            return $freelancer->portfolios()->where('portfolio_id', $portfolio->id)->exists();
        } else {
            // Check if the freelancer is a member of the team and the team owns the portfolio
            $team = Team::find($teamId);
            if ($team && $team->freelancers->contains($freelancer->id)) {
                return $team->portfolios()->where('portfolio_id', $portfolio->id)->exists();
            }
        }

        return false;
    }

    public function delete(Freelancer $freelancer,  Portfolio $portfolio, ?int $teamId = null)
    {
        if (is_null($teamId)) {
            // Check if the freelancer owns the portfolio
            return $freelancer->portfolios()->where('portfolio_id', $portfolio->id)->exists();
        } else {
            // Check if the freelancer is a member of the team and the team owns the portfolio
            $team = Team::find($teamId);
            if ($team && $team->freelancers->contains($freelancer->id)) {
                return $team->portfolios()->where('portfolio_id', $portfolio->id)->exists();
            }
        }

        return false;
    }
}
