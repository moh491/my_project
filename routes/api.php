<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyControllers\CompanyAuthController;
use App\Http\Controllers\CompanyControllers\JobController;
use App\Http\Controllers\FreelancerControllers\CertificateController;
use App\Http\Controllers\FreelancerControllers\EducationController;
use App\Http\Controllers\FreelancerControllers\ExperienceController;
use App\Http\Controllers\FreelancerControllers\FreelancerAuthController;
use App\Http\Controllers\FreelancerControllers\FreelancerController;
use App\Http\Controllers\FreelancerControllers\LanguageController;
use App\Http\Controllers\FreelancerControllers\PortfolioController;
use App\Http\Controllers\FreelancerControllers\ProfilePageController;
use App\Http\Controllers\FreelancerControllers\ServiceController;
use App\Http\Controllers\FreelancerControllers\SkillController;
use App\Http\Controllers\FreelancerControllers\WorkProfileController;
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

Route::controller(FreelancerAuthController::class)->prefix('Freelancer')->group(function () {

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
    Route::get('/reviews/{id}','getReviews');
    Route::post('updateAbout/{id}','updateAbout');
});
Route::controller(WorkProfileController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/work-profile/{id}','getWorkProfile');
});
Route::controller(PortfolioController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/portfolio/{id}','getPortfolios');
});
Route::controller(ServiceController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/services/{id}','getServices');
});
Route::controller(ProfilePageController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/freelancer/{id}','getProfilePage');
    Route::post('update-profile/{id}','updateProfile');
});
Route::controller(CertificateController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-certificate/{id}','insert');
    Route::post('update-certificate/{id}','update');
    Route::post('delete-certificate/{id}','delete');
});
Route::controller(ExperienceController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-experience/{id}','insert');
    Route::post('update-experience/{id}','update');
    Route::post('delete-experience/{id}','delete');
});
Route::controller(EducationController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-education/{id}','insert');
    Route::post('update-education/{id}','update');
    Route::post('delete-education/{id}','delete');
});
Route::controller(LanguageController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-lan/{id}','insert');
    Route::post('delete-lan/{id}','delete');
});
Route::controller(SkillController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-skill/{id}','insert');
    Route::post('delete-skill/{id}','delete');
});
Route::controller(JobController::class)->prefix('job')->middleware('auth:sanctum')->group(function(){
    Route::post('/insert','insert');
    Route::put('/update/{id}','update');
    Route::delete('/delete/{id}','delete');
});
