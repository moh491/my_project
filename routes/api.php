<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyControllers\CompanyAuthController;
use App\Http\Controllers\CompanyControllers\JobController;
//use App\Http\Controllers\Controller1;
use App\Http\Controllers\FilterFreelancerController;
use App\Http\Controllers\FreelancerControllers\ApplicationController;
use App\Http\Controllers\FreelancerControllers\CertificateController;
use App\Http\Controllers\FreelancerControllers\EducationController;
use App\Http\Controllers\FreelancerControllers\ExperienceController;
use App\Http\Controllers\FreelancerControllers\FeatureServiceController;
use App\Http\Controllers\FreelancerControllers\FreelancerAuthController;
use App\Http\Controllers\FreelancerControllers\FreelancerController;
use App\Http\Controllers\FreelancerControllers\LanguageController;
use App\Http\Controllers\FreelancerControllers\OfferController;
use App\Http\Controllers\FreelancerControllers\PlanServiceController;
use App\Http\Controllers\FreelancerControllers\PortfolioController;
use App\Http\Controllers\FreelancerControllers\ProfilePageController;
use App\Http\Controllers\FreelancerControllers\ServiceController;
use App\Http\Controllers\FreelancerControllers\SkillController;
use App\Http\Controllers\FreelancerControllers\WorkProfileController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Project_OwnersControllers\DashboardOwnerController;
use App\Http\Controllers\Project_OwnersControllers\ProjectController;
use App\Http\Controllers\Project_OwnersControllers\ProjectOwnersAuthController;
use App\Http\Controllers\Project_OwnersControllers\RequestServiceController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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
Route::controller(CompanyAuthController::class)->prefix('Company')->group(function () {

    Route::post('/register', 'register');

});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getdata', [AuthController::class, 'index']);
Route::controller(AuthController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', 'logout');
    Route::post('/verifyOtp', 'verifyOtp');
    Route::post('userForgotPassword', 'userForgotPassword');
    Route::post('/userResetPassword', 'userResetPassword');

});

Route::controller(FreelancerController::class)->middleware('auth:sanctum')->group(function () {

    Route::get('freelancer','index');
    Route::get('/basic-info/{id?}', 'getBasicInformation');
    Route::get('/reviews/{id?}', 'getReviews');
    Route::put('updateAbout', 'updateAbout');
});
Route::controller(WorkProfileController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/work-profile/{id?}', 'getWorkProfile');
});
Route::controller(PortfolioController::class)->prefix('portfolio')->middleware('auth:sanctum')->group(function () {
    Route::get('/{portfolioId}', 'getDetailsPortfolios');
    Route::get('/{id?}/{type?}', 'getPortfolios');
    Route::post('/{TeamId?}', 'insert');
    Route::delete('/{portfolioId}', 'delete');
    Route::put('/{portfolioId}', 'update');
});
Route::controller(ServiceController::class)->prefix('service')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{id?}/{type?}', 'getServices');
    Route::get('/{id}', 'detailService');
    Route::post('/{TeamId?}', 'insertService');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
Route::controller(ProfilePageController::class)->prefix('profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/{id?}', 'getProfilePage');
    Route::put('/', 'updateProfile');
});
Route::controller(CertificateController::class)->prefix('certification')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
Route::controller(ExperienceController::class)->prefix('experience')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
Route::controller(EducationController::class)->prefix('education')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
Route::controller(LanguageController::class)->prefix('language')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::delete('/{id}', 'delete');
});

Route::controller(SkillController::class)->prefix('skill')->middleware('auth:sanctum')->group(function () {
    Route::get('/','index');
    Route::post('/{teamId?}', 'insert');
    Route::delete('/{skillId}/{teamId?}', 'delete');
});


Route::controller(JobController::class)->prefix('job')->group(function () {

    Route::get('/browse-jobs', 'browseJobs');
    Route::get('/filter', 'filterAll');
    Route::get('/details/{id}', 'jobDetails');
    Route::get('/job-options', 'getJobOptions');
    //Route::post('/search', 'searchJobs');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/insert', 'insert');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
    });
});


Route::controller(RequestServiceController::class)->middleware('auth:sanctum')->group(function(){
    Route::post('/request','RequestService');
    Route::get('browseService','browseService');
});


Route::controller(FeatureServiceController::class)->prefix('feature')->middleware('auth:sanctum')->group(function(){
    Route::post('/{serviceID}','insertFeature');
    Route::delete('/{featureID}','deleteFeature');

});

Route::controller(PlanServiceController::class)->prefix('plan')->middleware('auth:sanctum')->group(function () {
    Route::post('/{serviceID}', 'insert');
    Route::delete('/{id}', 'delete');
    Route::put('/{id}', 'update');
});


Route::controller(ProjectController::class)->prefix('project')->group(function () {

    Route::get('/details/{id}', 'projectDetails');
    Route::get('/project-options', 'projectOptions');
    Route::get('/browse-projects', 'browseProjects');
    Route::get('/filter', 'filterAll');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store', 'store');
    });

});

Route::controller(OfferController::class)->prefix('offer')->group(function () {
    Route::get('/project-options', 'offerOptions');
    Route::get('/browse-offers/{projectId}', 'browseOffers');
    Route::get('/filter', 'filterAll');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store', 'insert');
        Route::delete('delete/{id}', 'delete');
    });


 });
Route::controller( ApplicationController::class)->prefix('app')->group(function (){
    Route::get('/application-options', 'applicationOptions');
    Route::get('/browse-applications','browseApplications');
    Route::get('/filter','filterAll');

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('store','insert');
        Route::delete('delete/{id}','delete');
    });

});

Route::controller(FilterFreelancerController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('filterFreelancers','filterAll');
});


Broadcast::routes(['middleware' => ['auth']]);

Route::controller(MessagesController::class)->prefix('chat')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'fetchConversations');
    Route::get('/{conversationId}', 'fetchMessages');
    Route::post('/', 'sendMessage');
});

Route::controller(ServiceRequestController::class)->prefix('serviceRequest')->middleware('auth:sanctum')->group(function(){
    Route::put('/{id}','update');
});


Route::controller(DashboardOwnerController::class)->prefix('dashboard')->group(function (){
   Route::get('/owner/{id}','endPoint');
});

Route::controller(\App\Http\Controllers\StripePaymentController::class)->prefix('payment')->middleware('auth:sanctum')->group(function ($router) {
    Route::get('/success', 'successPayment')->name('checkout.success');
    Route::get('/cancel', 'cancel')->name('checkout.cancel');
    Route::post('/confirm', 'confirm')->name('confirm');
    Route::post('/refund', 'refund')->name('refund');



});

