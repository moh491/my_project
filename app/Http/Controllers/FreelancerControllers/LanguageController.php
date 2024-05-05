<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Requests\LanguageRequest;
use App\Services\LanguageService;
use App\Traits\ApiResponseTrait;

class LanguageController
{
    use ApiResponseTrait;
    public function insert(LanguageRequest $request,string $id,LanguageService $languageService){
        try {
            $validator = $request->validated();
            $languageService->create($id,$validator);
            return $this->success('insert successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function delete(string $id,LanguageService $languageService){
        try {
            $languageService->delete($id);
            return $this->success('deleted successful');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
