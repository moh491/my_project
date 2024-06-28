<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;
use App\Models\Feature;
use App\Models\Service;
use App\Models\Team;
use App\Services\FeatureService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeatureServiceController extends Controller
{
    use ApiResponseTrait;
    protected $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }
    public function insertFeature(FeatureRequest $request,$serviceID){
        try {
            $validator = $request->validated();
            $service=Service::find($serviceID);
            if(! Auth::guard('Freelancer')->user()->can('access', [ Feature::class,$service] ) ) {
                return $this->error('not authorized');
            }
            $this->featureService->create($serviceID,$validator);
            return $this->success('insert feature successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function deleteFeature($featureID){
        try {
            $feature = Feature::find($featureID);
           $service= Service::find($feature->service_id);
            if (!Auth::guard('Freelancer')->user()->can('access', [Feature::class, $service])) {
                return $this->error('not authorized');
            }
            $this->featureService->delete($featureID);
            return $this->success('deleted successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
