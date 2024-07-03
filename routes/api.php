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
    Route::get('/basic-info/{id?}', 'getBasicInformation');
    Route::get('/reviews/{id?}', 'getReviews');
    Route::post('updateAbout', 'updateAbout');
});
Route::controller(WorkProfileController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/work-profile/{id?}', 'getWorkProfile');
});
Route::controller(PortfolioController::class)->prefix('portfolio')->middleware('auth:sanctum')->group(function () {
    Route::get('/{id?}/{type?}', 'getPortfolios');
    Route::post('/insert/{TeamId?}', 'insert');
    Route::post('/delete/{portfolioId}', 'delete');
    Route::get('/detailsPortfolio/{portfolioId}', 'getDetailsPortfolios');
    Route::post('/updatePortfolio/{portfolioId}', 'update');
});
Route::controller(ServiceController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/services/{id?}/{type?}', 'getServices');
    Route::get('service-details/{id}', 'detailService');
    Route::post('/insertService/{TeamId?}', 'insertService');
    Route::post('/updateService/{id}', 'update');
    Route::post('deleteService/{id}', 'delete');
});
Route::controller(ProfilePageController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/freelancer/{id?}', 'getProfilePage');
    Route::post('update-profile', 'updateProfile');
});
Route::controller(CertificateController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/insert-certificate', 'insert');
    Route::post('update-certificate/{id}', 'update');
    Route::post('delete-certificate/{id}', 'delete');
});
Route::controller(ExperienceController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/insert-experience', 'insert');
    Route::post('update-experience/{id}', 'update');
    Route::post('delete-experience/{id}', 'delete');
});
Route::controller(EducationController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/insert-education', 'insert');
    Route::post('update-education/{id}', 'update');
    Route::post('delete-education/{id}', 'delete');
});
Route::controller(LanguageController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/insert-lan', 'insert');
    Route::post('delete-lan/{id}', 'delete');
});
Route::controller(SkillController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('skills','index');
    Route::post('insert-skill/{teamId?}', 'insert');
    Route::post('delete-skill/{skillId}/{teamId?}', 'delete');
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

Route::controller(RequestServiceController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('requestService', 'RequestService');
});
Route::controller(FeatureServiceController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('createFeature/{serviceID}', 'insertFeature');
    Route::post('deleteFeature/{featureID}', 'deleteFeature');

});
Route::controller(PlanServiceController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('createPlan/{serviceID}', 'insert');
    Route::post('deletePlan/{id}', 'delete');
    Route::post('updatePlan/{id}', 'update');
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
    Route::get('/browse-offers', 'browseOffers');
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


Route::controller(FilterFreelancerController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('filterFreelancers', 'filterAll');

});
Route::controller(DashboardOwnerController::class)->prefix('dashboard')->group(function (){
   Route::get('/owner/{id}','endPoint');
});
