<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Services\LanguageService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class LanguageController
{
    use ApiResponseTrait;
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }
    public function insert(LanguageRequest $request){
        try {
            $validator = $request->validated();
            $id = Auth::guard('Freelancer')->user()->id;
            $this->languageService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function delete(string $id){
        try {
            $language=Language::find($id);
            if( Auth::guard('Freelancer')->user()->can('delete', [ Language::class, $language ] ) ){
                $this->languageService->delete($id);
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
