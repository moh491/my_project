<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateRequest;
use App\Services\CertificateService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    use ApiResponseTrait;
    public function insert(CertificateRequest $request,string $id,CertificateService $certificateService){
        try {
            $validator = $request->validated();
             $certificateService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function update(Request $request,string $id,CertificateService $certificateService){
        try {
            $data = $request->all();
             $certificateService->update($id,$data);
            return $this->success('updated successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function delete(string $id,CertificateService $certificateService){
        try {
            $certificateService->delete($id);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
