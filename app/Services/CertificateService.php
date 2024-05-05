<?php

namespace App\Services;

use App\Http\Resources\CertificateResource;
use App\Models\Certification;
use App\Models\Freelancer;

class CertificateService
{
    public function create(string $id,array $data){
      Certification::create([
            'title'=>$data['title'],
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date'],
            'image'=>$data['image'],
            'link'=>$data['link'],
            'credentials_id'=>$data['credentials_id'],
            'freelancer_id'=>$id,
        ]);

    }
    public function update(string $id,array $data){
        Certification::where('id',$id)->update($data);
    }
    public function delete(string $id){
        Certification::where('id',$id)->delete();
    }


}
