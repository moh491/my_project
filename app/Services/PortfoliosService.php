<?php

namespace App\Services;

use App\Http\Resources\PortfolioResource;
use App\Models\Freelancer;

class PortfoliosService
{
    public function getPortfolios(string $id){
        $freelancer=Freelancer::find($id);
        $portfolios = $freelancer->portfolios;
        return PortfolioResource::collection($portfolios);
    }
}
