<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\EducationUpdateRequest;
use App\Models\Education;
use App\Services\EducationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    use ApiResponseTrait;
    protected $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }
    public function index($id)
    {
        $education=Education::find($id);
        return $this->success('get education',$education);
    }
    public function insert(EducationRequest $request){
        try {
            $validator = $request->validated();
            $id = Auth::guard('Freelancer')->user()->id;
            $this->educationService ->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function update(EducationUpdateRequest $request,string $id){
        try {
            $data = $request->validated();
            $education =Education::find($id);
            if( Auth::guard('Freelancer')->user()->can('access', [ Education::class, $education ] ) ){
                $this->educationService ->update($id,$data);
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
            $education =Education::find($id);
            if( Auth::guard('Freelancer')->user()->can('access', [ Education::class, $education ] ) ){
                $this->educationService ->delete($id);
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
