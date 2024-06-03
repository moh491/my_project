<?php

namespace App\Services;

use App\Models\Feature;

class FeatureService
{
    public function create($id,$data){
       $featuer= Feature::create([
           'name'=>$data['name'],
           'is_boolean'=>$data['is_boolean'],
           'service_id'=>$id
       ]);
      $featuer->plans()->attach($data['plans_feature']);
    }
    public function delete($id){
        Feature::where('id',$id)->delete();
    }

}
