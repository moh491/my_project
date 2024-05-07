<?php

namespace App\Services;

use App\Models\Education;

class EducationService
{
    public function create(string $id,array $data){
        Education::create([
            'title'=>$data['title'],
            'institution'=>$data['institution'],
            'location'=>$data['location'],
            'start_year'=>$data['start_year'],
            'end_year'=>$data['end_year'],
            'average'=> $data['average'],
            'description'=> $data['description'],
            'freelancer_id'=>$id,
        ]);
    }
    public function update(string $id,array $data){
        Education::where('id',$id)->update($data);
    }
    public function delete(string $id){
        Education::where('id',$id)->delete();
    }

}
