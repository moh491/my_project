<?php

namespace App\Services;

use App\Http\Resources\BasicInfoResource;
use App\Http\Resources\CertificationResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\FreelancerResource;
use App\Http\Resources\PortfolioResource;
use App\Http\Resources\ProjectReviewsResource;
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
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use MongoDB\Driver\Query;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;



class FreelancerService
{

public function createFreelancer(array $freelancerData){
  $freelancer = Freelancer::create([
      'first_name' => $freelancerData['first_name'],
      'last_name' => $freelancerData['last_name'],
      'email' => $freelancerData['email'],
      'password' => bcrypt($freelancerData['password']),
      'position_id' => $freelancerData['position_id'],
      'about' => $freelancerData['about'],
      'location' => $freelancerData['location'],
      'time_zone' => $freelancerData['time_zone'],
  ]);
  $freelancer->skills()->attach( $freelancerData['skills']);
  if(isset($freelancerData['profile'])){
      $imageName = $freelancer->id . '-' . $freelancerData['profile']->getClientOriginalName();
      $path = $freelancerData['profile']->storeAs( 'freelancer-profile', $imageName, 'public');
      $freelancer->update(['profile'=>$path]);
  }
  foreach ($freelancerData['languages'] as $language){
      Language::create([
          'language'=>$language['name'],
          'level'=>$language['level'],
          'freelancer_id'=>$freelancer->id,
      ]);
  }
    $freelancer['token'] =  $freelancer->createToken('auth-Freelancer-token',['role:Freelance'])->plainTextToken;
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
    return new BasicInfoResource($freelancer);
}
public function getReviews(string $id)
{
    $freelancer = Freelancer::find($id);
    $projects = $freelancer->projects()->has('review')->get();
    return ProjectReviewsResource::collection($projects);
}
public function updateAbout($about){
    $freelancer=Auth::guard('Freelancer')->user();
    $freelancer->update(['about'=>$about['about']]);

}
public function filterAll(){
    $freelancers = QueryBuilder::for(Freelancer::class)
        ->allowedFilters([
            'location',
            'time_zone',
            AllowedFilter::exact('position_id'),
            AllowedFilter::exact('position.field_id'),
            AllowedFilter::scope('name')
        ])
        ->get();
    return FreelancerResource::collection($freelancers);

}


}
