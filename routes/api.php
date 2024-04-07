<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyControllers\CompanyAuthController;
 use App\Http\Controllers\FreelancerControllers\FreelancerAuthController;
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

Route::controller( AuthController::class)->group(function () {

    Route::post('/login', 'login');
    Route::post('/logout' , 'logout')->middleware('auth:sanctum');

});

