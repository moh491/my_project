<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioRequest;
use App\Http\Requests\PortfolioUpdateRequest;
use App\Models\Portfolio;
use App\Models\Team;
use App\Services\FreelancerService;
use App\Services\PortfoliosService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class PortfolioController extends Controller
{
    use ApiResponseTrait;

    protected $portfoliosService;

    public function __construct(PortfoliosService $portfoliosService)
    {
        $this->portfoliosService = $portfoliosService;
    }

    public function getPortfolios($id = null, $type = null)
    {
        try {
            ($type == "team") ? $model = 'App\\Models\\Team' : $model = 'App\\Models\\Freelancer';
            if (!$id) {
                $id = Auth::guard('Freelancer')->user()->id;
                $model = 'App\\Models\\Freelancer';
            }
            $information = $this->portfoliosService->getPortfolios($id, $model);
            return $this->success('get portfolios', $information);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getDetailsPortfolios(string $portfolioId): \Illuminate\Http\JsonResponse
    {
        try {
            $information = $this->portfoliosService->getDetailsPortfolio($portfolioId);
            return $this->success('get details portfolio', $information);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function insert(PortfolioRequest $request, $id = null): \Illuminate\Http\JsonResponse
    {
        try {
            if ($id) {
                $type = 'team';
            } else {
                $type = 'freelancer';
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $validator = $request->validated();
            if ($type == "team") {
                $team = Team::find($id);
                if (!Auth::guard('Freelancer')->user()->can('isMemberOfTeam', [Portfolio::class, $team])) {
                    return $this->error('not authorized');
                }
            }
            $this->portfoliosService->createPortfolio($id, $type, $validator);
            return $this->success('insert portfolio successfully');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $portfolio = Portfolio::find($id);
            if (Auth::guard('Freelancer')->user()->can('access', [Portfolio::class, $portfolio])) {
                $this->portfoliosService->delete($id);
                return $this->success('deleted successful');
            } else {
                return $this->error('not authorized');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function update(PortfolioUpdateRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $portfolio = Portfolio::find($id);
            if (Auth::guard('Freelancer')->user()->can('access', [Portfolio::class, $portfolio])) {
                $this->portfoliosService->update($id, $data);
                return $this->success('updated successful');
            } else {
                return $this->error('not authorized');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }
}
