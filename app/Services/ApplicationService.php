<?php

namespace App\Services;

use App\Filtering\FillterApplication;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\OfferResource;
use App\Models\Application;
use App\Traits\ApiResponseTrait;
use Spatie\QueryBuilder\QueryBuilder;

class ApplicationService
{
    use ApiResponseTrait;

    public function applyForJob(StoreApplicationRequest $request)
    {
        return Application::create($request->all());
    }

    public function removeApplication($id): void
    {
        $application = Application::findOrFail($id);
        $application->delete();
    }

    public function browseApplications($freelancer_id)
    {
        return Application::where('freelancer_id', $freelancer_id)->get();
    }

    public function filterAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $applications = QueryBuilder::for(Application::class)
            ->allowedFilters((new FillterApplication())->filterAll())
            ->get();

        return OfferResource::collection($applications);

    }

    public function getApplicationOptions()
    {

    }

}
