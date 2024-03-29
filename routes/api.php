<?php

use App\Http\Controllers\CompanyControllers\CompanyAuthController;
use App\Http\Controllers\FreelacerControllers\FreelacerAuthController;
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

Route::controller( FreelacerAuthController::class)->prefix('Freelancer')->group(function () {

    Route::post('/register', 'register');

});

Route::controller(CompanyAuthController::class)->prefix('Company')->group(function () {

   Route::post('/register', 'register');
   Route::post('/login', 'login');
   Route::post('logout','logout')->middleware('auth:sanctum');
});





