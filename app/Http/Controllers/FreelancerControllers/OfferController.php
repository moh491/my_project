<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Resources\OfferResource;
use App\Services\OfferService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    use ApiResponseTrait;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }


    public function index(string $projectId): \Illuminate\Http\JsonResponse
    {
        try {
            $offers = OfferResource::collection($this->offerService->getAll($projectId));
            return $this->success('Get index successfully', $offers);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function insert(StoreOfferRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->offerService->create($request->validated());
            return $this->success('insert successful');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->offerService->delete($id);
            return $this->success('deleted successfully');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function offerOptions(): \Illuminate\Http\JsonResponse
    {
        try {
            $options = $this->offerService->getOfferOptions();
            return $this->success('successfully', $options);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function browseOffers(string $id = null): \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        try {
            if (!$id) {
                $id = Auth::guard('Freelancer')->user()->id;
                $model = 'App\\Models\\Freelancer';
            } else
                $model = 'App\\Models\\Team';

            $offers = OfferResource::collection($this->offerService->getOffers($id,$model));
            return $this->success('Get browse successfully', $offers);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


    public function filterAll(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $offers = $this->offerService->filterAll();
            return $this->success('successfully', $offers);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }


}
