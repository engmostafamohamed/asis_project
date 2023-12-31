<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController ;
use App\Http\Controllers\HomeController\SliderController;
use App\Http\Controllers\HomeController\CustomerController;
use App\Http\Controllers\HomeController\CompanyServiceController;
use App\Http\Controllers\HomeController\CompanyProfilesController;
use App\Http\Controllers\HomeController\CompanyObjectiveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/home',[HomePageController::class,'fetchData']);


Route::prefix('dashboard')->group(function () {
    Route::post('/slider',[SliderController::class,'store']);
    Route::get('/sliders', [SliderController::class,'index']);
    Route::get('/slider/{id}',[SliderController::class,'show']);
    Route::post('/slider/{id}', [SliderController::class,'update']);
    Route::delete('/slider/{id}', [SliderController::class,'delete']);

    Route::post('/customer',[CustomerController::class,'store']);
    Route::get('/customers', [CustomerController::class,'index']);
    Route::get('/customer/{id}',[CustomerController::class,'show']);
    Route::post('/customer/{id}', [CustomerController::class,'update']);
    Route::delete('/customer/{id}', [CustomerController::class,'delete']);

    Route::post('/company_service',[CompanyServiceController::class,'store']);
    Route::get('/company_services', [CompanyServiceController::class,'index']);
    Route::get('/company_service/{id}',[CompanyServiceController::class,'show']);
    Route::post('/company_service/{id}', [CompanyServiceController::class,'update']);
    Route::delete('/company_service/{id}', [CompanyServiceController::class,'delete']);

    Route::post('/company_profile',[CompanyProfilesController::class,'store']);
    Route::get('/company_profiles', [CompanyProfilesController::class,'index']);
    Route::get('/company_profile/{id}',[CompanyProfilesController::class,'show']);
    Route::post('/company_profile/{id}', [CompanyProfilesController::class,'update']);
    Route::delete('/company_profile/{id}', [CompanyProfilesController::class,'delete']);

    Route::post('/company_objective',[CompanyObjectiveController::class,'store']);
    Route::get('/company_objectives', [CompanyObjectiveController::class,'index']);
    Route::get('/company_objective/{id}',[CompanyObjectiveController::class,'show']);
    Route::post('/company_objective/{id}', [CompanyObjectiveController::class,'update']);
    Route::delete('/company_objective/{id}', [CompanyObjectiveController::class,'delete']);
});
