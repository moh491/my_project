<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyControllers\CompanyAuthController;
 use App\Http\Controllers\FreelancerControllers\FreelancerAuthController;
use App\Http\Controllers\FreelancerControllers\FreelancerController;
use App\Http\Controllers\Project_OwnersControllers\ProjectOwnersAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller( FreelancerAuthController::class)->prefix('Freelancer')->group(function () {

    Route::post('/register', 'register');

});

Route::controller(ProjectOwnersAuthController::class)->prefix('ProjectOwner')->group(function () {

    Route::post('/register', 'register');
});
Route::controller(  CompanyAuthController::class)->prefix('Company')->group(function () {

    Route::post('/register', 'register');

});
Route::post('/login',[AuthController::class,'login']);
Route::controller( AuthController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/logout' , 'logout');
    Route::post('/verifyOtp','verifyOtp');
    Route::post('userForgotPassword','userForgotPassword');
    Route::post('/userResetPassword','userResetPassword');

});
Route::controller(FreelancerController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/basic-info/{id}','getBasicInformation');
    Route::get('/work-profile/{id}','getWorkProfile');
    Route::get('/portfolio/{id}','getPortfolios');
    Route::get('/reviews/{id}','getReviews');
    Route::get('/services/{id}','getServices');

});

