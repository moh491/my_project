<?php

namespace App\Services;

use App\Enums\Offer_Type;
use App\Filtering\FilterOffers;
use App\Http\Resources\OfferResource;
use App\Mail\SentMail;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Project_Owners;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;

class OfferService
{
    use ApiResponseTrait;

    public function create(array $data, $id, $type): void
    {
        $data['worker_type'] = $type;
        $data['worker_id'] = $id;
        $offer = Offer::create([
            'project_id' => $data['project_id'],
            'duration' => $data['duration'],
            'budget' => $data['budget'],
            'description' => $data['description'],
            'worker_type' => $data['worker_type'],
            'worker_id' => $data['worker_id'],
        ]);


        if (isset($data['files'])) {
            $folderPath = 'offer/' . $offer->id;
            foreach ($data['files'] as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs($folderPath, $fileName, 'public');
            }
            $offer->update(['files' => $folderPath]);
        }

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
        $description = $project_owner->first_name . ' ' . $project_owner->last_name . ' has accepted the offer for the project ' . $project->title;
        $title = 'Accept Offer';
        if ($offer['worker_type'] == 'App\\Models\\Freelancer') {
            Mail::to($user->email)->send(new SentMail($title, $description));
        } else {
            $owner_team = $user->freelancers()->where('is_owner', 1)->first();

        }
    }

    public function RejectOffer($id)
    {
        $offer = Offer::find($id);
        $offer->update(['status' => 'Reject']);
        $project = Project::find($offer['project_id']);
        $project_owner = Project_Owners::find(Auth::guard('Project_Owner')->user()->id);
        $user = $offer['worker_type']::find($offer['worker_id']);
        $description = $project_owner->first_name . ' ' . $project_owner->last_name . ' has reject the offer for the project ' . $project->title;
        $title = 'Reject Offer';
        if ($offer['worker_type'] == 'App\\Models\\Freelancer') {
            Mail::to($user->email)->send(new SentMail($title, $description));
        } else {
            $owner_team = $user->freelancers()->where('is_owner', 1)->first();
            Mail::to($owner_team->email)->send(new SentMail($title, $description));
        }
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
            //mail
            if ($offer['worker_type'] == 'App\\Models\\Freelancer') {
                $description = $user->first_name . ' ' . $user->last_name . ' has canceled the receipt of the project ' . $project->title;
            } else {
                $description = $user->name . ' has canceled the receipt of the project ' . $project->title;
            }
            $title = 'Cancel Receipt of the ServiceMail';
            Mail::to($owner->email)->send(new SentMail($title, $description));
        }

    }


    public function getOfferOptions()
    {


        $owner = Project::has('offers')
            ->join('project__owners', 'projects.project_owner_id', '=', 'project__owners.id')
            ->select('projects.id', 'project__owners.first_name', 'project__owners.last_name')
            ->distinct()->orderBy('projects.created_at', 'desc')
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
        return Offer::where('project_id', $projectId)->where('status','!=','Reject')->orderBy('created_at','desc')->paginate(10);
    }

    public function getOffers(string $id, $model)
    {
        return Offer::where('worker_type', $model)->where('worker_id', $id)->orderBy('created_at','desc')->paginate(10);
    }

    public function filterAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $offers = QueryBuilder::for(Offer::class)
            ->allowedFilters((new FilterOffers())->filterAll())->with('project')->orderBy('created_at','desc')
            ->get();

        return OfferResource::collection($offers);

    }

}
