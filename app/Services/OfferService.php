<?php

namespace App\Services;

use App\Enums\Offer_Type;
use App\Filtering\FilterOffers;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Project_Owners;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function AcceptOffer($id)
    {
        $offer = Offer::find($id);
        $project = Project::find($offer['project_id']);
        $project->update(['worker_type' => $offer['worker_type'], 'worker_id' => $offer['worker_id'], 'status' => 'Underway', 'start_date' => Carbon::now()]);
        $offer->update(['status' => 'Accept']);
        $project_owner = Project_Owners::find(Auth::guard('Project_Owner')->user()->id);
        $user = $offer['worker_type']::find($offer['worker_id']);
        $project_owner->update(['suspended_balance' => $project_owner['suspended_balance'] + $offer['budget'], 'withdrawal_balance' => $project_owner['withdrawal_balance'] - $offer['budget']]);
        $user->update(['suspended_balance' => $user['suspended_balance'] + ($offer['budget'] - $offer['budget'] * 0.15)]);
        //mail
    }

    public function cancel($id)
    {
        $offer = Offer::find($id);
        $project = Project::find($offer['project_id']);
        if ($offer['status'] == 'Pending') {
            $offer->delete();
        } else if ($offer['status'] == 'Accept') {
            $owner = Project_Owners::find($project['project_owner_id']);
            $user = $offer['worker_type']::find($offer['worker_id']);
            $project->update(['worker_type' => Null, 'worker_id' => Null, 'status' => 'Open', 'start_date' => Null]);
            $owner->update(['suspended_balance' => $owner['suspended_balance'] - $offer['budget'], 'withdrawal_balance' => $owner['withdrawal_balance'] + $offer['budget']]);
            $user->update(['suspended_balance' => $user['suspended_balance'] - ($offer['budget'] - $offer['budget'] * 0.15)]);
            $offer->delete();
        }
        //mail

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
            ->allowedFilters((new FilterOffers())->filterAll())->with('project')
            ->get();


        return OfferResource::collection($offers);

    }

}
