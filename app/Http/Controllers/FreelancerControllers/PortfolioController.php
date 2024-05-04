<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Services\FreelancerService;
use App\Services\PortfoliosService;
use App\Traits\ApiResponseTrait;

class PortfolioController extends Controller
{
    use ApiResponseTrait;
    public function getPortfolios(string $id,PortfoliosService $portfoliosService){
        try {
            $information = $portfoliosService->getPortfolios($id);
            return $this->success('get portfolios',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
}
