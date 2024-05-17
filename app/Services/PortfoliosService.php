<?php

namespace App\Services;

use App\Http\Resources\PortfolioDetailsResource;
use App\Http\Resources\PortfolioResource;
use App\Http\Resources\PortfolioTeamResource;
use App\Models\Freelancer;
use App\Models\Portfolio;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class PortfoliosService
{
    public function getPortfolios(string $id,$model){

        $user=$model::find($id);
        $portfolios = $user->portfolios;
        if($model=='App\\Models\\Freelancer'){
        return PortfolioResource::collection($portfolios);
        }
        return PortfolioTeamResource::collection($portfolios);
    }
    public function getDetailsPortfolio(string $id){
        $portfolio = Portfolio::find($id);
        return new PortfolioDetailsResource($portfolio);
    }
    public function createPortfolio(string $id,$type,$data){
       $portfolio = Portfolio::create($data);
        $portfolio->skills()->attach( $data['skills']);
        if($type=="freelancer") {
            $portfolio->freelancers()->attach($id);
            if(isset($data['contributors']))
            $portfolio->freelancers()->attach($data['contributors']);
        }
        else{
            $portfolio->team()->attach($id);
        }
    }

    public function delete(string $id,$teamId){
        $freelancer = Auth::user();
        if(!$teamId) {
            $freelancer->portfolios()->delete($id);
        }
        else {
            $team = Team::find($teamId);
            //Only team members can delete
            if ($team->freelancers->where('id', $freelancer->id)->first()) {
                $team->portfolios()->delete($id);
            }
        }
    }
    public function update(string $id,$teamId,array $data){

        $freelancer= Auth::user();
        if(!$teamId) {
            $portfolio = $freelancer->portfolios->find($id);
            $portfolio->update($data);
            if (isset($data['skills']))
                $portfolio->skills()->sync($data['skills']);
            if (isset($data['contributors'])) {
                $portfolio->freelancers()->sync($data['contributors']);
                $portfolio->freelancers()->attach($freelancer);
            }
        }
        else {
            $team = Team::find($teamId);
            //Only team members can update
            if ($team->freelancers->where('id', $freelancer->id)->first()) {
                $portfolio = $team->portfolios->find($id);
                $portfolio->update($data);
                if (isset($data['skills']))
                    $portfolio->skills()->sync($data['skills']);
            }
        }

    }

}
