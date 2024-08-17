<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Delivery_Option;
use App\Models\Plan;
use App\Models\Project_Owners;
use App\Models\Request;
use App\Models\Service;
use App\Models\Team;
use App\Services\FreelancerService;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use ApiResponseTrait;

    protected $servicesService;

    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
    }

    public function getServices($id = null, $type = null)
    {
        try {
            ($type == "team") ? $model = $model = 'App\\Models\\Team' : $model = 'App\\Models\\Freelancer';
            if (!$id) {
                $id = Auth::guard('Freelancer')->user()->id;
                $model = 'App\\Models\\Freelancer';
            }
            $information = $this->servicesService->getServices($id, $model);
            return $this->success('get services', $information);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function detailService($id)
    {
        try {
            $information = $this->servicesService->detailServices($id);
            return $this->success('get details service', $information);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function browseService()
    {
        try {
            $services = $this->servicesService->browseService();
            return $this->success('get Services', $services);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function insertService(ServiceRequest $request, $id = null)
    {
        try {
            if ($id) {
                $type = 'App\\Models\\Team';
            } else {
                $type = 'App\\Models\\Freelancer';
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $validator = $request->validated();
            if ($type == 'App\\Models\\Team') {
                $team = Team::find($id);
                if (!Auth::guard('Freelancer')->user()->can('isMemberOfTeam', [Service::class, $team])) {
                    return $this->error('not authorized');
                }
            }
            $this->servicesService->createService($id, $type, $validator);
            return $this->success('insert service successfully');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function update(ServiceUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $service = Service::find($id);
            if (Auth::guard('Freelancer')->user()->can('access', [Service::class, $service])) {
                $this->servicesService->update($id, $data);
                return $this->success('updated successful');
            } else {
                return $this->error('not authorized');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $service = Service::find($id);
            if (Auth::guard('Freelancer')->user()->can('access', [Service::class, $service])) {
                $this->servicesService->delete($id);
                return $this->success('deleted successful');
            } else {
                return $this->error('not authorized');
            }
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delivery($id)
    {

        try {
            $request = Request::find($id);
            $plan = Plan::find($request['plan_id']);
            $service = Service::find($plan['service_id']);
            if (Auth::guard('Freelancer')->user()->can('access', [Service::class, $service])) {
                $this->servicesService->serviceDelivery($id);
                return $this->success('delivery Successfully');
            } else {
                return $this->error("not authorized");
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }


    }

    public function Accept($id)
    {
        try {
            $request = Request::find($id);
            if ($request['project_owner_id'] == Auth::guard('Project_Owner')->user()->id) {
                $this->servicesService->AcceptService($id);
                //  return redirect(' ');
                return $this->success('Accept Service Successfully');
            } else {
                return $this->error('not authorized');
            }
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }


    }


}
