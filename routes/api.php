<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyControllers\CompanyAuthController;
use App\Http\Controllers\CompanyControllers\CompanyController;
use App\Http\Controllers\CompanyControllers\JobController;
//use App\Http\Controllers\Controller1;
use App\Http\Controllers\FieldController;
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
use App\Http\Controllers\FreelancerControllers\PdfController;
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
use App\Http\Controllers\TeamController;
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
    Route::get('/{portfolioId}', 'getDetailsPortfolios')->name('portfolio.show');
    Route::get('/{id?}/{type?}', 'getPortfolios');
    Route::post('/{TeamId?}', 'insert');
    Route::delete('/{portfolioId}', 'delete');
    Route::put('/{portfolioId}', 'update');
});
Route::controller(ServiceController::class)->prefix('service')->group(function () {
    Route::get('/index/{id?}/{type?}', 'getServices');
    Route::get('/filter','browseService')->name('service.show');
    Route::get('/{id}', 'detailService');
    Route::post('/{TeamId?}', 'insertService');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::post('delivery/{requestId}','delivery');
    Route::post('Accept/{requestId}','Accept')->name('Accept.service');
});
Route::controller(ProfilePageController::class)->prefix('freelancer/profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/{id?}', 'getProfilePage');
    Route::put('/', 'updateProfile');
});
Route::controller(CertificateController::class)->prefix('certification')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::get('/{id}','index');
});
Route::controller(ExperienceController::class)->prefix('experience')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::get('/{id}','index');
});
Route::controller(EducationController::class)->prefix('education')->middleware('auth:sanctum')->group(function () {
    Route::post('/', 'insert');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::get('/{id}','index');
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

Route::controller(CompanyController::class)->prefix('companies')->group(function (){
    Route::get('/profile', 'getProfile');
    Route::get('/profile/{id}', 'getCompanyProfile');
    Route::put('/update', 'update');
    Route::get('/','index')->name('company.show');
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



Route::controller(RequestServiceController::class)->prefix('request')->middleware('auth:sanctum')->group(function(){
    Route::post('/','RequestService');
    Route::get('/requestedServicesOwner','browseRequestedServicesforowner');
    Route::get('/requestedServicesUser/{id?}','browseRequestedServicesforUser');
    Route::delete('/{id}','deleteRequestService');
    Route::put('/{requestId}','rating');
    Route::post('Accept/{requestId}','Accept');
    Route::post('Reject/{requestId}','Reject');
    Route::post('Cancel/{requestId}','Cancel');
    Route::get('/{id}','details')->name('request.show');
    Route::get('/get/{id}','getRequests');




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
        Route::post('delivery/{projectId}','delivery');
        Route::post('rating/{projectId}','rating');
        Route::post('Accept/{offerId}','Accept')->name('Accept.project');
    });

});

Route::controller(OfferController::class)->prefix('offer')->middleware('auth:sanctum')->group(function () {
    Route::get('/offer-options', 'offerOptions');
    Route::get('/browse-offers/{id?}', 'browseOffers');
    Route::get('/filter', 'filterAll');
    Route::get('/{projectId}', 'index');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store/{id?}', 'insert');
        Route::post('cancel/{id}','Cancelreceiptproject');
        Route::post('Accept/{offerId}','Accept');
        Route::post('Reject/{id}','Reject');
        Route::get('details/{id}','details')->name('details.show');
    });


 });
Route::controller( ApplicationController::class)->prefix('app')->group(function (){
    Route::get('/application-options', 'applicationOptions');
    Route::get('/browse-applications','browseApplications');
    Route::get('/filter','filterAll');

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('store','insert');
        Route::delete('delete/{id}','delete');
        Route::get('/getFreelancerApplications','getFreelancerApplications');
        Route::get('/getCompanyApplications','getCompanyApplications');
        Route::put('/{id}','ChangeStatusToReviewed');
        Route::post('Accept/{id}','Accept');
        Route::post('Reject/{id}','Reject');
        Route::post('filter/{jobId}','filterOfApplication');
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




Route::controller(DashboardOwnerController::class)->prefix('dashboard')->group(function (){
   Route::get('/owner/{id?}','endPoint');

    Route::middleware('auth:Project_Owner')->group(function () {
        Route::post('/update','update');
    });

});

Route::controller(\App\Http\Controllers\StripePaymentController::class)->prefix('payment')->group(function ($router) {
    Route::get('/success', 'successPayment')->name('checkout.success');
    Route::get('/cancel', 'cancel')->name('checkout.cancel');
    Route::post('/confirm', 'confirm')->name('confirm')->middleware('auth:sanctum');
    Route::post('/refund', 'refund')->name('refund')->middleware('auth:sanctum');



});

Route::get('generate-cv', [PdfController::class, 'generateCV'])->middleware('auth:sanctum');

Route::controller(TeamController::class)->prefix('team')->group(function () {
    Route::get('/getTeamReviews/{id}' , 'getTeamReviews');

    Route::middleware('auth:Freelancer')->group(function (){
        Route::get('profile/{id}','getProfilePage')->name('team.show');
        Route::get('/my-team' , 'myTeams');
        Route::post('/store',  'store');
        Route::put('/update/{team}',  'update');
        Route::post('/{team}/add-member','addMember');
        Route::delete('/{team}/remove-member', 'removeMember');
        Route::delete('/{team}/remove-team' , 'deleteTeam');
    });

});

Route::get('endPoint', [FieldController::class, 'endPoint']);
