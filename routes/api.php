<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyControllers\CompanyAuthController;
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
    Route::get('/basic-info/{id?}','getBasicInformation');
    Route::get('/reviews/{id?}','getReviews');
    Route::post('updateAbout','updateAbout');
});
Route::controller(WorkProfileController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/work-profile/{id?}','getWorkProfile');
});
Route::controller(PortfolioController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/portfolio/{id?}/{type?}','getPortfolios');
    Route::post('/insert/{TeamId?}','insert');
    Route::post('delete/{portfolioId}/{teamId?}','delete');
    Route::get('detailsPortfolio/{portfolioId}','getDetailsPortfolios');
    Route::post('updatePortfolio/{portfolioId}/{teamId?}','update');
});
Route::controller(ServiceController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/services/{id?}/{type?}','getServices');
    Route::get('service-details/{id}','detailService');
});
Route::controller(ProfilePageController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/freelancer/{id?}','getProfilePage');
    Route::post('update-profile','updateProfile');
});
Route::controller(CertificateController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-certificate','insert');
    Route::post('update-certificate/{id}','update');
    Route::post('delete-certificate/{id}','delete');
});
Route::controller(ExperienceController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-experience','insert');
    Route::post('update-experience/{id}','update');
    Route::post('delete-experience/{id}','delete');
});
Route::controller(EducationController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-education','insert');
    Route::post('update-education/{id}','update');
    Route::post('delete-education/{id}','delete');
});
Route::controller(LanguageController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/insert-lan','insert');
    Route::post('delete-lan/{id}','delete');
});
Route::controller(SkillController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('insert-skill/{teamId?}','insert');
    Route::post('delete-skill/{skillId}/{teamId?}','delete');
});
