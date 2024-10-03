<?php

use App\Http\Controllers\AppointmentFormController;
use App\Http\Controllers\ManageAppointmentController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SlotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('slots',SlotController::class);


Route::apiResource('positions', PositionController::class);


Route::prefix('appointment')->controller(AppointmentFormController::class)->group(function (){
    Route::post('create', 'store');
    Route::post('check-existence', 'existingAppointment');
   
});

Route::prefix('manage-appointment')->controller(ManageAppointmentController::class)
->group(function () {
    Route::post('list','index');
   
    Route::post('update','');
    Route::post('delete','');
});


