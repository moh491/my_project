<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRatingRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Requests\UpdateServiceRequestRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Request;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(ServicesService $service)
    {
        $this->service = $service;
    }

    public function update(UpdateRequestRequest $requestRequest, string $id)
    {
        try {
            $request = Request::find($id);
            $data = $requestRequest->validated();
            if (Auth::guard('Freelancer')->user()) {
                if (Auth::guard('Freelancer')->user()->can('updateStatus', [Request::class, $request])) {
                    $this->service->updateStatus($data, $id);
                    return $this->success('updated status successful');
                }
            } else if (Auth::guard('Project_Owner')->user()) {
                if (Auth::guard('Project_Owner')->user()->can('updateRating', [Request::class, $request])) {
                    $this->service->updateRating($data, $id);
                    return $this->success('updated rating successful');
                }
            }

            return $this->error('not authorized');

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

}
