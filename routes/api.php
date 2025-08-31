<?php

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

Route::group(['prefix' => 'auth'],function () {
    Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group([ 'middleware' => ['auth:sanctum',config('jetstream.auth_session'),'verified','verify.user.active']], function () {
    Route::apiResource('activity', App\Http\Controllers\API\AtividadeAPIController::class);
    Route::apiResource('vehicle', App\Http\Controllers\API\VeiculoAPIController::class)->except(['show']);
    
    Route::get('drawAgent/{atividade}',[App\Http\Controllers\API\AtividadeAPIController::class,'drawAgent']);
    
    Route::patch('acceptTrip/{atividade}',[App\Http\Controllers\API\AtividadeAPIController::class,'acceptTrip']);
    Route::post('cancel/{atividade}',[App\Http\Controllers\API\AtividadeAPIController::class,'cancel']);
    
    Route::apiResource('vehicle', App\Http\Controllers\API\VeiculoAPIController::class);
    
    Route::get('profileData',[App\Http\Controllers\API\ProfileAPIController::class,'getProfileData']);
    Route::post('updateProfile',[App\Http\Controllers\API\ProfileAPIController::class,'updateProfileData']);
    
    Route::get('getOnline',[App\Http\Controllers\API\AgenteAPIController::class,'getOnline']);
    Route::get('getOffline',[App\Http\Controllers\API\AgenteAPIController::class,'getOffline']);

    Route::get('vehicle/setActive/{veiculo}',[App\Http\Controllers\API\VeiculoAPIController::class,'setActive']);

});

Route::get('marker/{user}',[App\Http\Controllers\API\AtividadeAPIController::class,'marker']);






Route::resource('asds', App\Http\Controllers\API\asdAPIController::class)
    ->except(['create', 'edit']);