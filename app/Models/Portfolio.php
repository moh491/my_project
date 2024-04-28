<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;
    //Get all of the skills for the portfolio.
    public function skills(){
        return $this->morphToMany(Skill::class, 'skillable','skillable__skills');
    }

    //Get all of the freelancers that are assigned this portfolio.
    public function freelancers()
    {
        return $this->morphedByMany(Freelancer::class, 'owner','owner__portfolios');
    }

}
