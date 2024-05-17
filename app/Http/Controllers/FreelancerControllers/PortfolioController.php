<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioRequest;
use App\Services\FreelancerService;
use App\Services\PortfoliosService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class PortfolioController extends Controller
{
    use ApiResponseTrait;
    public function getPortfolios(PortfoliosService $portfoliosService,$id=null,$type=null){
        try {
            ($type=="team")?$model='App\\Models\\Team':$model='App\\Models\\Freelancer';
            if(!$id){
                $id=Auth::user()->id;
                $model='App\\Models\\Freelancer';
            }
            $information = $portfoliosService->getPortfolios($id,$model);
            return $this->success('get portfolios', $information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function getDetailsPortfolios(string $portfolioId,PortfoliosService $portfoliosService){
        try {
            $information = $portfoliosService->getDetailsPortfolio($portfolioId);
            return $this->success('get details portfolio',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function insert(PortfolioRequest $request,PortfoliosService $portfoliosService,$id=null){
        try {
            ($id)?$type='team':$type='freelancer' && $id=Auth::user()->id;
            $validator = $request->all();
            $portfoliosService->createPortfolio($id,$type,$validator);
            return $this->success('insert portfolio successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function delete(string $id,PortfoliosService $portfoliosService,$teamId=null){
        try {

            $portfoliosService->delete($id,$teamId);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function update(Request $request,string $id,PortfoliosService $portfoliosService,$teamId=null){
        try {
            $data = $request->all();
           $portfoliosService->update($id,$teamId,$data);
            return $this->success('updated successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
}
