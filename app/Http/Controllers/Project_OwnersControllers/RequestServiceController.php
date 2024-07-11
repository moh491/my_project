<?php

namespace App\Http\Controllers\Project_OwnersControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAServiceRequest;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestServiceController extends Controller
{
    use ApiResponseTrait;

    protected $servicesService;

    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
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

    public function browseService()
    {
        try {
            $services = $this->servicesService->browseService();
            return $this->success('get Services', $services);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function browseRequestedServices()
    {
        try {
            $services = $this->servicesService->browseRequestedServicesforproject_owner();
            return $this->success('get requested services', $services);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }
}
