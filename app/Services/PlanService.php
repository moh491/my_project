<?php

namespace App\Services;

use App\Models\Delivery_Option;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\Service;

class PlanService
{
    public function create($id,$data){
       $plan= Plan::create([
            'price'=>$data['price'],
            'description'=>$data['description'],
            'type'=>$data['type'],
            'service_id'=>$id,
        ]);
       $service=Service::find($id);
       foreach ($data['features'] as $feature) {
           //Check if this feature of this service
           $f=Feature::find($feature['id']);
           if($f['service_id']==$id) {
               $plan->features()->attach($feature['id'],['value'=>$feature['value']]);
          }
       }
        foreach ($data['delivery_options'] as $delivery_option) {
            Delivery_Option::create([
                'days' => $delivery_option['days'],
                'increase' => $delivery_option['increase'],
                'plan_id' => $plan->id
            ]);
        }
    }
    public function delete($id){
        Plan::where('id',$id)->delete();
    }
    public function update($id,$data){
      $plan = Plan::find($id);
      $plan->update($data);
      if(isset($data['features'])){
          foreach ($data['features'] as $feature) {
                  $plan->features()->where('feature_id',$feature['id'])->update(['value'=>$feature['value']]);
          }
      }
      if(isset($data['delivery_options'])){
          foreach ($data['delivery_options'] as $delivery_option ){
              if(!isset($delivery_option['id'])){
                  Delivery_Option::create([
                      'days'=>$delivery_option['days'],
                      'increase'=>$delivery_option['increase'],
                      'plan_id'=>$plan->id
                  ]);
              }
              else if($delivery_option['id']==0 || $delivery_option['id']==null ){
                  Delivery_Option::create([
                      'days'=>$delivery_option['days'],
                      'increase'=>$delivery_option['increase'],
                      'plan_id'=>$plan->id
                  ]);
              }
              else{
                 $d= Delivery_Option::find($delivery_option['id']);
                 $d->update($delivery_option);
              }
          }
      }
    }


}
