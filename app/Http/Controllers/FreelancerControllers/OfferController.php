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

    public function insert(StoreOfferRequest $request ): \Illuminate\Http\JsonResponse
    {
        try {
            $offer = $this->offerService->create($request->validated());
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->offerService->delete($id);
            return $this->success('deleted successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function offerOptions(): \Illuminate\Http\JsonResponse
    {
        try {
            $options = $this->offerService->getOfferOptions();
            return $this->success('successfully',$options);
        }catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function browseOffers(): \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        try {
            $projects = $this->offerService->getAllOffers();
            return OfferResource::collection($projects);
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function filterAll(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $projects = $this->offerService->filterAll();
            return $this->success('success',$projects);
        } catch  (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
