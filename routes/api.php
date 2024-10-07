<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\SlotController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AppointmentFormController;
use App\Http\Controllers\ManageAppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix'=>'auth'], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'register']);
    Route::get('list',[AuthController::class,'index']);
});
Route::middleware(['auth:api'])->group(function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::apiResource('slots',SlotController::class);


Route::apiResource('positions', PositionController::class);


Route::prefix('appointment')->controller(AppointmentFormController::class)->group(function (){
    Route::post('create', 'store');
    Route::post('check-existence', 'existingAppointment');

});
Route::post('positions/change-status/{id}', [PositionController::class, 'changeStatus']);


Route::prefix('manage-appointment')->controller(ManageAppointmentController::class)
->group(function () {
    Route::get('list','index');
    Route::get('show/{id}','show');
    Route::delete('delete/{id}','destroy');
    Route::get('interview-cancel/{id}','interviewCancel');
    Route::get('interview-done/{id}','interviewDone');

});


