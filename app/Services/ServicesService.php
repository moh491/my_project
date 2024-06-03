<?php

namespace App\Services;

use App\Http\Resources\ServiceDetailsResource;
use App\Http\Resources\ServiceResource;
use App\Models\Delivery_Option;
use App\Models\Feature;
use App\Models\Freelancer;
use App\Models\Plan;
use App\Models\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServicesService
{
    public function getServices(string $id, $model)
    {
        $user = $model::find($id);
        $services = $user->services;
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
        foreach ($data['plans'] as $planData) {
            $plan = Plan::create([
                'price' => $planData['price'],
                'description' => $planData['description'],
                'type' => $planData['type'],
                'service_id' => $service->id
            ]);
            foreach ($planData['features'] as $featureData) {
                $feature = Feature::firstOrCreate([
                    'name' => $featureData['name'],
                    'is_boolean' => $featureData['is_boolean'],
                    'service_id' => $service->id
                ]);
                $plan->features()->attach($feature->id, ['value' => $featureData['value']]);
            }
            foreach ($planData['delivery_options'] as $delivery_option) {
                Delivery_Option::create([
                    'days' => $delivery_option['days'],
                    'increase' => $delivery_option['increase'],
                    'plan_id' => $plan->id
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
        if (isset($data['image'])) {
            $files = Storage::files('public/' . $service->image);
            foreach ($files as $file) {
                if ($file !== 'public/' . $service->preview) {
                    Storage::delete($file);
                }
            }
            foreach ($data['image'] as $image) {
                $imageName = $image->getClientOriginalName();
                $image->storeAs('service/' . $service->id, $imageName, 'public');
            }
            $service->update(['image' => 'service/' . $service->id]);
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

    }


}
