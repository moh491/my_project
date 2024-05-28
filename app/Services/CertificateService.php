<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Models\Certification;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Storage;

class CertificateService extends Controller
{
    public function create(string $id,array $data){
      $certification =Certification::create([
            'title'=>$data['title'],
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date'],
            'image'=>$data['image'],
            'link'=>$data['link'],
            'credentials_id'=>$data['credentials_id'],
            'freelancer_id'=>$id,
        ]);
        if(isset($data['image'])){
            $imageName = $certification->id . '-' . $data['image']->getClientOriginalName();
            $path = $data['image']->storeAs( 'Certification', $imageName, 'public');
            $certification->update(['image'=>$path]);
        }

    }
    public function update(string $id,array $data){
        $certification = Certification::find($id);
        if ($data['image']) {
            Storage::disk('public')->delete($certification->image);
            $imageName = $certification->id. '-' . $data['image']->getClientOriginalName();
            $path = $data['image']->storeAs('Certification', $imageName, 'public');
            $certification->update(['image' => $path]);
        }
        unset($data['image']);
        $certification->update($data);
    }
    public function delete(string $id){
        $certification=Certification::find($id);
        Certification::where('id',$id)->delete();
        Storage::disk('public')->delete($certification->image);
    }


}
