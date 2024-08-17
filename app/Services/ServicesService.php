<?php

namespace App\Services;

use App\Enums\Status;
use App\Filtering\Search1Filter;
use App\Filtering\SearchFilter;
use App\Filtering\SearchServiceFilter;
use App\Filtering\ServiceTitleFilter;
use App\Http\Resources\RequestResource;
use App\Http\Resources\ServiceDetailsResource;
use App\Http\Resources\ServiceResource;
use App\Jobs\CloseServiceJob;
use App\Mail\SentMail;
use App\Mail\ServiceMail;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\Project_Owners;
use App\Models\Request;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ServicesService
{
    public function getServices(string $id, $model)
    {
        $user = $model::find($id);
        $services = $user->services()->orderBy('created_at', 'desc')->get();
        return ServiceResource::collection($services);
    }

    public function detailServices(string $id)
    {
        $service = Service::find($id);
        return new ServiceDetailsResource($service);
    }

    public function createService($id, $model, $data)
    {
        $service = Service::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'owner_type' => $model,
            'owner_id' => $id
        ]);
        $service->skills()->attach($data['skills']);
        if (isset($data['image'])) {
            $folderPath = 'service/' . $service->id;
            foreach ($data['image'] as $image) {
                $imageName = $image->getClientOriginalName();
                $image->storeAs($folderPath, $imageName, 'public');
            }
            $service->update(['image' => $folderPath]);
        }
        if (isset($data['preview'])) {
            $imageName = $data['preview']->getClientOriginalName();
            $path = $data['preview']->storeAs('service/' . $service->id, $imageName, 'public');
            $service->update(['preview' => $path]);
        }

        $featureIds = [];
        foreach ($data['features'] as $featureData) {
            $feature = Feature::create([
                'name' => $featureData['name'],
                'is_boolean' => isset($featureData['is_boolean']),
                'service_id' => $service->id
            ]);
            $featureIds [] = $feature->id;
        }
//
        foreach ($data['plans'] as $planData) {
            $plan = Plan::create([
                'price' => $planData['price'],
                'description' => $planData['description'],
                'type' => $planData['type'],
                'service_id' => $service->id
            ]);
            foreach ($planData['features'] as $index => $featureData) {
                DB::table('plan__features')->insert([
                    'value' => $featureData['value'] ?? false,
                    'plan_id' => $plan->id,
                    'feature_id' => $featureIds[$index],
                ]);
            }

        }
    }

    public function update($id, $data)
    {
        $service = Service::find($id);
        if (isset($data['preview'])) {
            Storage::disk('public')->delete($service->preview);
            $imageName = $data['preview']->getClientOriginalName();
            $path = $data['preview']->storeAs('service/' . $service->id, $imageName, 'public');
            $service->update(['preview' => $path]);
        }

        $existImages = $data['existImages'] ?? [];
        $files = Storage::files('public/' . $service->image);
        foreach ($files as $file) {
            if ($file !== 'public/' . $service->preview && !in_array($file, $existImages)) {
                Storage::delete($file);
            }
        }


        if (isset($data['image'])) {
            foreach ($data['image'] as $image) {
                $imageName = $image->getClientOriginalName();
                $image->storeAs('service/' . $service->id, $imageName, 'public');
            }
            $service->update(['image' => 'service/' . $service->id]);
        }


        if (isset($data['skills'])) {
            $service->skills()->sync($data['skills']);
        }

        unset($data['image']);
        unset($data['preview']);
        $service->update($data);
    }

    public function delete($id)
    {
        Service::where('id', $id)->delete();
        $folderPath = 'public/service/' . $id;
        Storage::deleteDirectory($folderPath);
    }

    public function requestService($id, $data)
    {
        $request = Request::create([
            'project_owner_id' => $id,
            'plan_id' => $data['plan_id'],
            'note' => $data['note']
        ]);
        $owner = Project_Owners::find($id);
        $plan = Plan::find($data['plan_id']);
        $owner->update(['suspended_balance' => $owner['suspended_balance'] + $plan['price'], 'withdrawal_balance' => $owner['withdrawal_balance'] - $plan['price']]);
        if (isset($data['files'])) {
            $folderPath = 'Request/' . $request->id;
            foreach ($data['files'] as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs($folderPath, $fileName, 'public');
            }
            $request->update(['files' => $folderPath]);
        }
    }

    public function browseService()
    {
        $services = QueryBuilder::for(Service::class)
            ->allowedFilters([
                AllowedFilter::exact('skills.id'),
                AllowedFilter::custom('search', new Search1Filter(['title', 'description'])),
            ])->orderBy('created_at','desc')->get();
        return ServiceDetailsResource::collection($services);
    }

    public function updateRating($data, $id)
    {
        $request = Request::find($id);
        $request->update(['rating' => $data['rating']]);
    }

    public function browseRequestedServicesforproject_owner(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $project_owner = Auth::guard('Project_Owner')->user();

        $requests = QueryBuilder::for(Request::query()
            ->join('plans', 'requests.plan_id', '=', 'plans.id')
            ->join('services', 'plans.service_id', '=', 'services.id')
            ->where('requests.project_owner_id', $project_owner->id)
            ->select('requests.*'))
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::callback('service_title', function ($query, $value) {
                    return $query->where('services.title', 'like', '%' . $value . '%');
                })
            ])
            ->orderBy('created_at','desc')->get();


        return RequestResource::collection($requests);


    }

    public function browseRequestedServicesforfreelancer($id, $type)
    {

        $requests = QueryBuilder::for(Request::query()
            ->join('plans', 'requests.plan_id', '=', 'plans.id')
            ->join('services', 'plans.service_id', '=', 'services.id')
            ->where('services.owner_type', $type)
            ->where('services.owner_id', $id)
            ->select('requests.*'))
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::callback('service_title', function ($query, $value) {
                    return $query->where('services.title', 'like', '%' . $value . '%');
                })
            ])
            ->with('project_owners')->orderBy('created_at','desc')->get();

        return RequestResource::collection($requests);


    }

    public function deleteRequest($id)
    {
        $request = Request::find($id);
        $owner = Project_Owners::find($request['project_owner_id']);
        $plan = Plan::find($request['plan_id']);
        $owner->update(['suspended_balance' => $owner['suspended_balance'] - $plan['price'], 'withdrawal_balance' => $owner['withdrawal_balance'] + $plan['price']]);
        Storage::disk('public')->delete($request->files);
        $request->delete();
    }

    public function AcceptRequest($id)
    {
        $request = Request::find($id);
        $owner = Project_Owners::find($request['project_owner_id']);
        $plan = Plan::find($request['plan_id']);
        $service = Service::find($plan['service_id']);
        $user = $service['owner_type']::find($service['owner_id']);
        $request->update(['status' => Status::UNDERWAY]);
        $user->update(['suspended_balance' => $user['suspended_balance'] + ($plan['price'] - $plan['price'] * 0.15)]);
        if ($service['owner_type'] == 'App\\Models\\Freelancer') {
            $description = $user->first_name . ' ' . $user->last_name . ' has accepted request of service ' . $service->title;
        } else {
            $description = $user->name . '  has accepted request of service ' . $service->title;
        }
        $title = 'Accept Request';
        Mail::to($owner->email)->send(new SentMail($title, $description));
    }

    public function rejectRequest($id)
    {
        $request = Request::find($id);
        $owner = Project_Owners::find($request['project_owner_id']);
        $plan = Plan::find($request['plan_id']);
        $service = Service::find($plan['service_id']);
        $user = $service['owner_type']::find($service['owner_id']);
        $request->update(['status' => Status::EXCLUDED]);
        $owner->update(['suspended_balance' => $owner['suspended_balance'] - $plan['price'], 'withdrawal_balance' => $owner['withdrawal_balance'] + $plan['price']]);
        if ($service['owner_type'] == 'App\\Models\\Freelancer') {
            $description = $user->first_name . ' ' . $user->last_name . ' has reject the request for the service ' . $service->title;
        } else {
            $description = $user->name . '  has reject the request for the service ' . $service->title;
        }
        $title = 'Reject Request';
        Mail::to($owner->email)->send(new SentMail($title, $description));

    }

    //status =completed,mail for owner
    //if the service owner the freelancer or team
    public function serviceDelivery($id)
    {
        $request = Request::find($id);
        $request->update(['status' => Status::COMPLETED]);
        $owner = Project_Owners::find($request['project_owner_id']);
        $plan = Plan::find($request['plan_id']);
        $service = Service::find($plan['service_id']);
        $user = $service['owner_type']::find($service['owner_id']);
        $title = 'Service Delivery';
        if ($service['owner_type'] == 'App\\Models\\Freelancer') {
            $description = $user->first_name . ' ' . $user->last_name . ' has delivery of the service ' . $service->title;
        } else {
            $description = $user->name . '  has delivery of the service ' . $service->title;
        }
        Mail::to($owner->email)->send(new ServiceMail($title, $description,$id));
    }

    //owner
    //status under review
    //the user convert the balance suspended to balance available
    //send mail to freelancer or team
    //return redirect rating
    //job (delete the suspended balance of owner and convert the balance available to withdrawal balance ,Request status completed)
    public function AcceptService($id)
    {
        $request = Request::find($id);

        $request->update(['status' => Status::UnderReview]);

        $owner = Project_Owners::find($request['project_owner_id']);
        $plan = Plan::find($request['plan_id']);
        $service = Service::find($plan['service_id']);
        $user = $service['owner_type']::find($service['owner_id']);

        $user->update(['suspended_balance' => $user['suspended_balance'] - ($plan['price'] - $plan['price'] * 0.15), 'available_balance' => $user['available_balance'] + ($plan['price'] - $plan['price'] * 0.15)]);

        $title = 'Accept Service';
        $description = $owner->first_name . ' ' . $owner->last_name . ' has accepted the service ' . $service->title;

        if ($service['owner_type'] == 'App\\Models\\Freelancer') {
            Mail::to($user->email)->send(new SentMail($title, $description));
        } else {
            $owner_team = $user->freelancers()->where('is_owner', 1)->first();
            Mail::to($owner_team->email)->send(new SentMail($title, $description));
        }

        $now = Carbon::now();
        $futureDate = $now->copy()->addDays(14);
        $secondsDifference = $futureDate->diffInSeconds($now);
        CloseServiceJob::dispatch($id)->delay($secondsDifference);

    }

    //freelancer or team cancel
    //convert the suspended balance to withdrawal balance in owner
    //minus in suspended balance in user
    //delete the request
    //mail for owner
    public function cancel($id)
    {
        $request = Request::find($id);
        if ($request->status == Status::UNDERWAY) {
            $owner = Project_Owners::find($request['project_owner_id']);
            $plan = Plan::find($request['plan_id']);
            $service = Service::find($plan['service_id']);
            $user = $service['owner_type']::find($service['owner_id']);

            $owner->update(['suspended_balance' => $owner['suspended_balance'] - $plan['price'], 'withdrawal_balance' => $owner['withdrawal_balance'] + $plan['price']]);

            $user->update(['suspended_balance' => $user['suspended_balance'] - ($plan['price'] - $plan['price'] * 0.15)]);

            $request->delete();

            $title = 'Cancel Receipt of the Service';
            if ($service['owner_type'] == 'App\\Models\\Freelancer') {
                $description = $user->first_name . ' ' . $user->last_name . ' has canceled the receipt of the service ' . $service->title;
            } else {
                $description = $user->name . '  has canceled the receipt of the service ' . $service->title;
            }
            Mail::to($owner->email)->send(new SentMail($title, $description));
        }

    }


}
