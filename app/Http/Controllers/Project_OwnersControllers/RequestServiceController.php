<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAServiceRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Resources\RequestResource;
use App\Models\Delivery_Option;
use App\Models\Plan;
use App\Models\Project_Owners;
use App\Models\Request;
use App\Models\Service;
use App\Models\Team;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;

use Illuminate\Support\Facades\Auth;

class RequestServiceController extends Controller
{
    use ApiResponseTrait;

    protected $servicesService;

    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
    }
    public function getRequests($id){

        try {
           $service=Service::find($id);
           $requests=$service->allRequests();
            return $this->success('get requests successfully',RequestResource::Collection($requests));
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function RequestService(RequestAServiceRequest $request)
    {
        try {
            $id = Auth::guard('Project_Owner')->user()->id;
            $data = $request->validated();
            $this->servicesService->requestService($id, $data);
            return $this->success('Service requested successfully');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function browseRequestedServicesforowner()
    {
        try {
            $services = $this->servicesService->browseRequestedServicesforproject_owner();
            return $this->success('get requested services', $services);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function browseRequestedServicesforUser($id = null)
    {
        try {
            if ($id) {
                $type = 'App\\Models\\Team';
            } else {
                $type = 'App\\Models\\Freelancer';
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $requests = $this->servicesService->browseRequestedServicesforfreelancer($id, $type);
            return $this->success('get requested services ', $requests);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function deleteRequestService($id)
    {
        try {
            $request = Request::find($id);
            if (Auth::guard('Project_Owner')->user()->id == $request->project_owner_id && $request->status == 'Pending') {
                $this->servicesService->deleteRequest($id);
                return $this->success('deleted successfully');
            } else {
                return $this->error(" You can't delete");
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function rating(UpdateRequestRequest $requestRequest, string $id)
    {
        try {
            $request = Request::find($id);
            $data = $requestRequest->validated();
            if (Auth::guard('Project_Owner')->user()->can('updateRating', [Request::class, $request])) {
                $this->servicesService->updateRating($data, $id);
                return $this->success('updated rating successful');
            }

            return $this->error('not authorized');

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function Accept($id)
    {
        try {
            $request = Request::find($id);
            if (Auth::guard('Freelancer')->user()->can('authorized', [Request::class, $request])) {
                $this->servicesService->AcceptRequest($id);
                return $this->success('Accept Request Successfully');
            } else {
                return $this->error("not authorized");
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }


    }

    public function Reject($id)
    {
        try {
            $request = Request::find($id);
            if (Auth::guard('Freelancer')->user()->can('authorized', [Request::class, $request])) {
                $this->servicesService->rejectRequest($id);
                return $this->success('Reject Request Successfully');
            } else {
                return $this->error("not authorized");
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function Cancel($id)
    {
        try {
            $request = Request::find($id);
            if (Auth::guard('Freelancer')->user()->can('authorized', [Request::class, $request])) {
                $this->servicesService->cancel($id);
                return $this->success('cancel receipt of the service successfully');
            } else {
                return $this->error("not authorized");
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }

    public function details($id)
    {
        try {

            $request = Request::find($id);
            if(Auth::guard('Project_Owner')->user()->id==$request['project_owner_id']) {
                return $this->success('get request details', new RequestResource($request));
            }
            else {
                return $this->error('not authorized');
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }


}
