<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateRequest;
use App\Http\Requests\CertificateUpdateRequest;
use App\Models\Certification;
use App\Models\Freelancer;
use App\Services\CertificateService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    use ApiResponseTrait;
    protected $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function index($id)
    {
        $certification=Certification::find($id);
        return $this->success('get certification',$certification);
    }
    public function insert(CertificateRequest $request){
        try {
            $id = Auth::guard('Freelancer')->user()->id;
            $validator = $request->validated();
            $this->certificateService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function update(CertificateUpdateRequest $request,string $id){
        try {
            $data = $request->validated();
            $certification=Certification::find($id);
            if( Auth::guard('Freelancer')->user()->can('access', [ Certification::class, $certification ] ) ){
                $this->certificateService->update($id, $data);
                return $this->success('updated successful');
            }else{
                return $this->error('not authorized');
            }
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id){
        try {
            $certification=Certification::find($id);
            if( Auth::guard('Freelancer')->user()->can('access', [ Certification::class, $certification ] ) ){
                $this->certificateService->delete($id);
                return $this->success('deleted successful');
            }else{
                return $this->error('not authorized');
            }
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
