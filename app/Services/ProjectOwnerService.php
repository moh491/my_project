<?php

namespace App\Services;

use App\Mail\SendCodeEmail;
use App\Models\Otp;
use App\Models\Project_Owners;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProjectOwnerService
{
    public function createProjectOwner(array $projectownerData){
        $project_owner=Project_Owners::create([
            'first_name' => $projectownerData['first_name'],
            'last_name' => $projectownerData['last_name'],
            'email' => $projectownerData['email'],
            'password' => bcrypt($projectownerData ['password']),
            'about'=>$projectownerData['about'],
            'location'=>$projectownerData['location'],
            'time_zone'=>$projectownerData['time_zone'],
        ]);
        if(isset($projectownerData['profile'])){
            $imageName = $project_owner->id . '-' . $projectownerData['profile']->getClientOriginalName();
            $path = $projectownerData['profile']->storeAs( 'project-owner-profile', $imageName, 'public');
            $project_owner->update(['profile'=>$path]);
        }
        $project_owner->fields()->attach($projectownerData['field_id']);
        $project_owner['token'] =  $project_owner->createToken('auth-project-owner-token',['role:project_owner'])->plainTextToken;
        $code = mt_rand(100000, 999999);
        while(Otp::where('otp', $code)->exists()){
            $code = mt_rand(100000, 999999);
        }
        Otp::create([
            'otpable_id'=>$project_owner->id,
            'otpable_type'=>'App\\Models\\Project_Owners',
            'otp'=>$code,
            'otp_expiry_time'=>now()->addMinute(15),
        ]);
        Mail::to($project_owner->email)->send(new SendCodeEmail($code));
        return $project_owner;
    }

    public function updateProjectOwner(Project_Owners $projectOwner, array $data)
    {
        if (isset($data['profile'])) {
            if ($projectOwner->profile && Storage::exists($projectOwner->profile)) {
                Storage::delete($projectOwner->profile);
            }

            $path = $data['profile']->store('profiles', 'public');
            $data['profile'] = $path;
        }

        $updateData = array_filter($data, function($key) {
            return $key !== 'field_ids';
        }, ARRAY_FILTER_USE_KEY);

        $projectOwner->update($updateData);


        if (isset($data['field_ids'])) {
            $projectOwner->fields()->sync($data['field_ids']);
        }

        return $projectOwner;
    }


}
