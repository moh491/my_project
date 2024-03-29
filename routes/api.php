<?php

use App\Http\Controllers\CompanyControllers\CompanyAuthController;
use App\Http\Controllers\FreelancerControllers\FreelancerAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller( FreelancerAuthController::class)->prefix('Freelancer')->group(function () {

    Route::post('/register', 'Register');
    Route::post('/login', 'Login');
    Route::post('/logout','Logout');


});

Route::controller(  CompanyAuthController::class)->prefix('Company')->group(function () {

    Route::post('/register', 'register');


});

