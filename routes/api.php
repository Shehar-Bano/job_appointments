<?php

use App\Http\Controllers\AppointmentFormController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SlotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('slots',SlotController::class);
Route::post('slots/change-status/{id}', [SlotController::class, 'changeStatus']);

Route::apiResource('positions', PositionController::class);


Route::prefix('appointment')->controller(AppointmentFormController::class)->group(function (){
    Route::post('create', 'store');
   
});


