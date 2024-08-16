<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Project_Owners;
use App\Models\Team;
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


    public function insert(StoreOfferRequest $request, $id = null): \Illuminate\Http\JsonResponse
    {
        try {
            if ($id == null) {
                $id = Auth::guard('Freelancer')->user()->id;
                $type = 'App\\Models\\Freelancer';
            } else {
                $type = 'App\\Models\\Team';
                $team = Team::find($id);
                if (!$team->freelancers->contains(Auth::guard('Freelancer')->user()->id)) {
                    return $this->error('not authorized');
                }
            }
            $data=$request->validated();
            $existingOffer = Offer::where('worker_type', $type)
                ->where('worker_id', $id)
                ->where('project_id', $data['project_id'])
                ->first();

            if ($existingOffer) {
                return $this->error('You have already applied to this project.');
            }

            $this->offerService->create($data, $id, $type);
            return $this->success('insert successful');
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function Accept($id)
    {
        try {
            $offer = Offer::find($id);
            $project = Project::find($offer['project_id']);
            if ($project['project_owner_id'] == Auth::guard('Project_Owner')->user()->id) {
                $owner = Project_Owners::find($project['project_owner_id']);
                if ($owner->withdrawal_balance < $offer['budget']) {
                    return $this->error('Please recharge balance before Accept Offer');
                }
                $this->offerService->AcceptOffer($id);
                return $this->success('Accept Offer Successfully');
            } else {
                return $this->error('not authorized');
            }
        } catch (\Throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function Cancelreceiptproject($id)
    {
        try {
            $offer = Offer::find($id);
            if (($offer['worker_type'] == 'App\\Models\\Freelancer' && $offer['worker_id'] == Auth::guard('Freelancer')->user()->id) || ($offer['worker_type'] == 'App\\Models\\Team' && Team::find($offer['worker_id'])->freelancers->contains(Auth::guard('Freelancer')->user()->id))) {
                $this->offerService->cancel($id);
                return $this->success('cancel receipt of the project successfully');
            } else {
                return $this->error('not authorized');
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

    public function Reject($id)
    {
        try {
            $offer = Offer::find($id);
            $project = Project::find($offer['project_id']);
            if ($project['project_owner_id'] == Auth::guard('Project_Owner')->user()->id) {
                $this->offerService->RejectOffer($id);
                return $this->success('Reject Offer Successfully');
            } else {
                return $this->error('not authorized');
            }
        } catch (\Throwable $throwable) {
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

            $offers = OfferResource::collection($this->offerService->getOffers($id, $model));
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

    public function details($id)
    {
        try {

            $offer = Offer::find($id);
            $project=Project::find($offer['project_id']);
            if(Auth::guard('Project_Owner')->user()->id==$project['project_owner_id']) {
                return $this->success('get offer details', new offerResource($offer));
            }
            else{
                return $this->error('not authorized');
            }

        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }

    }


}
