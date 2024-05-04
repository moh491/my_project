<?php

namespace App\Services;

use App\Http\Resources\CertificationResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\FreelancerResource;
use App\Http\Resources\PortfolioResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ServiceResource;
use App\Mail\SendCodeEmail;
use App\Models\Company;
use App\Models\Freelancer;
use App\Models\Language;
use App\Models\Otp;
use App\Models\Owner_Portfolio;
use App\Models\Portfolio;
use App\Models\Position;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;

class FreelancerService
{

public function createFreelancer(array $freelancerData){
  $freelancer = Freelancer::create([
      'first_name' => $freelancerData['first_name'],
      'last_name' => $freelancerData['Last_name'],
      'email' => $freelancerData['email'],
      'password' => bcrypt($freelancerData['password']),
      'position_id' => $freelancerData['position_id'],
      'about' => $freelancerData['about'],
      'location' => $freelancerData['location'],
      'time_zone' => $freelancerData['time_zone'],
  ]);
  $freelancer->skills()->attach( $freelancerData['skills']);
  foreach ($freelancerData['languages'] as $language){
      Language::create([
          'language'=>$language['lang'],
          'level'=>$language['level'],
          'freelancer_id'=>$freelancer->id,
      ]);
  }
    $freelancer['token'] =  $freelancer->createToken('auth-freelancer-token',['role:freelance'])->plainTextToken;
    $code = mt_rand(100000, 999999);
    while(Otp::where('otp', $code)->exists()){
        $code = mt_rand(100000, 999999);
    }
    Otp::create([
        'otpable_id'=>$freelancer->id,
        'otpable_type'=>'App\\Models\\Freelancer',
        'otp'=>$code,
        'otp_expiry_time'=>now()->addMinute(15),
    ]);
    Mail::to($freelancer->email)->send(new SendCodeEmail($code));
    return $freelancer;
}

public function basicInformation(string $id){
    $freelancer=Freelancer::find($id);
    $languages = $freelancer->languages()->select('language', 'level')->get();
    $skills=$freelancer->skills()->pluck('name');
    $response =[
        'about'=>$freelancer->about,
        'languages'=>$languages,
        'skills'=>$skills
    ];
    return $response;
}
public function getReviews(string $id)
{
    $freelancer = Freelancer::find($id);
    $projects = $freelancer->projects;
    return ReviewResource::collection($projects);
}


}
