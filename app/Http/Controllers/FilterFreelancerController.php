<?php

namespace App\Http\Controllers;

use App\Services\CertificateService;
use App\Services\FreelancerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class FilterFreelancerController extends Controller
{
    use ApiResponseTrait;
    protected $freelncerService;

    public function __construct(FreelancerService $freelncerService)
    {
        $this->freelncerService = $freelncerService;
    }
    public function filterAll(Request $request){
        try {
            $freelancer = $this->freelncerService->filterAll();
            return $this->success('success',$freelancer);
        } catch  (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
}
