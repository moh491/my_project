<?php

namespace App\Services;

use App\Enums\Offer_Type;
use App\Filtering\FilterOffers;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Project;
use App\Traits\ApiResponseTrait;
use Spatie\QueryBuilder\QueryBuilder;

class OfferService
{
    use ApiResponseTrait;

    public function create(array $data, $id, $type): Offer
    {

        $data['worker_type'] = $type;
        $data['worker_id'] = $id;

        if (isset($data['files']) && $data['files'] instanceof \Illuminate\Http\UploadedFile) {
            $data['files'] = $data['files']->store('offers', 'public');
        }

        return Offer::create($data);
    }

    public function delete(string $id): void
    {
        Offer::where('id', $id)->delete();
    }

    public function getOfferOptions()
    {


        $owner = Project::has('offers')
            ->join('project__owners', 'projects.project_owner_id', '=', 'project__owners.id')
            ->select('projects.id', 'project__owners.first_name', 'project__owners.last_name')
            ->distinct()
            ->get()
            ->map(function ($project) {
                $project->owner_name = $project->first_name . ' ' . $project->last_name;
                return $project;
            });


        return [
            'status' => Offer_Type::getValues(),
            'owner' => $owner,
        ];
    }

    public function getAll(string $projectId)
    {
        return Offer::where('project_id', $projectId)->paginate(10);
    }

    public function getOffers(string $id, $model)
    {
        return Offer::where('worker_type', $model)->where('worker_id', $id)->paginate(10);
    }

    public function filterAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $offers = QueryBuilder::for(Offer::class)
            ->allowedFilters((new FilterOffers())->filterAll())
            ->get();

        return OfferResource::collection($offers);

    }

}
