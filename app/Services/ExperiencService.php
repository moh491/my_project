<?php

namespace App\Services;

use App\Models\Experience;

class ExperiencService
{

    public function create(string $id,array $data){
        Experience::create([
            'company_name'=>$data['company_name'],
            'employment_type'=>$data['employment_type'],
            'location_type'=>$data['location_type'],
            'location'=>$data['location'],
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date'],
            'position_id'=> $data['position_id'],
            'company_id'=> $data['company_id']  ,
            'freelancer_id'=>$id,
        ]);
    }
    public function update(string $id,array $data){
        Experience::where('id',$id)->update($data);
    }
    public function delete(string $id){
        Experience::where('id',$id)->delete();
    }

}
