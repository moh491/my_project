<?php

namespace App\Services;

use App\Filtering\FilterJob;
use App\Http\Resources\BrowseJobs;
use App\Http\Resources\OfferResource;
use App\Models\Company;
use App\Models\Job;
use App\Models\Offer;
use App\Models\Position;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class OfferService
{
    use ApiResponseTrait;

    public function create(array $data): Offer
    {
      $freelancer = auth()->guard('Freelancer')->user();
        $data['worker_type'] = get_class($freelancer);
        $data['worker_id'] = $freelancer->id;

        if (isset($data['files']) && $data['files'] instanceof \Illuminate\Http\UploadedFile) {
            $data['files'] = $data['files']->store('offers', 'public');
        }

        return Offer::create($data);
    }

    public function delete(string $id): void
    {
        Offer::where('id', $id)->delete();
    }

    public function getOfferOptions(): void
    {


    }

    public function getAllOffers()
    {
        return Offer::paginate(10);

    }

    public function filterAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $projects = QueryBuilder::for(Offer::class)
            ->allowedFilters((new FilterProjects())->filterAll())
            ->with(['field:id,name'])
            ->get();

        return OfferResource::collection($projects);

    }



}
