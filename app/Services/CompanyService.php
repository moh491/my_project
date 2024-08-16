<?php

namespace App\Services;

use App\Http\Resources\CompanyResource;
use App\Mail\SendCodeEmail;
use App\Models\Company;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;

class CompanyService
{
    public function createCompany(array $companyData){
        $company = Company::create($companyData);
        if(isset($companyData['logo'])){
            $imageName = $company->id . '-' . $companyData['logo']->getClientOriginalName();
            $path = $companyData['logo']->storeAs( 'Company/company-logo', $imageName, 'public');
            $company->update(['logo'=>$path]);
        }
        $company['password'] = bcrypt($company ['password']);
        $company['token'] =  $company->createToken('auth-company-token',['role:Company'])->plainTextToken;
        $code = mt_rand(100000, 999999);
        while(Otp::where('otp', $code)->exists()){
            $code = mt_rand(100000, 999999);
        }
        Otp::create([
            'otpable_id'=>$company->id,
            'otpable_type'=>'App\\Models\\Company',
            'otp'=>$code,
            'otp_expiry_time'=>now()->addMinute(15),
        ]);
        Mail::to($company->email)->send(new SendCodeEmail($code));
        return $company;
    }

    public function getCompanyProfile($companyId)
    {
        $company = Company::with('jobs')->findOrFail($companyId);
        return new CompanyResource($company);
    }
}
