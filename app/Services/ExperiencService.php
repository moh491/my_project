<?php

namespace App\Services;

use App\Models\Experience;

class ExperiencService
{

    public function create(string $id,array $data){
        $experience=Experience::create([
            'employment_type'=>$data['employment_type'],
            'location_type'=>$data['location_type'],
            'location'=>$data['location'],
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date'],
            'position_id'=> $data['position_id'],
            'description'=>$data['description'],
            'freelancer_id'=>$id,
        ]);
        if(isset($data['company_id'])){
            $experience->update(['company_id'=>$data['company_id']]);
        }
        if(isset($data['company_name'])){
            $experience->update(['company_name'=>$data['company_name']]);
        }
    }
    public function update(string $id,array $data){
        Experience::where('id',$id)->update($data);
    }
    public function delete(string $id){
        Experience::where('id',$id)->delete();
    }

}
