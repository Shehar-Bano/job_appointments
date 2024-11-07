<?php
use App\Http\Controllers\AppointmentFormController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManageAppointmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 Route::middleware(['ip.check'])->group(function () {
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('signup', [AuthController::class, 'register']);
    Route::get('list', [AuthController::class, 'index']);
});
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::apiResource('slots', SlotController::class);



    Route::prefix('manage-appointment')->controller(ManageAppointmentController::class)
    ->group(function () {
        Route::get('list', 'index');
        Route::get('show/{id}', 'show');
        Route::delete('delete/{id}', 'destroy');
        Route::get('interview-cancel/{id}', 'interviewCancel');
        Route::get('interview-done/{id}', 'interviewDone');
    });
});
Route::apiResource('slots', SlotController::class);
Route::prefix('manage-appointment')->controller(ManageAppointmentController::class)
->group(function () {
    Route::get('list', 'index');
    Route::get('show/{id}', 'show');
    Route::delete('delete/{id}', 'destroy');
    Route::get('interview-cancel/{id}', 'interviewCancel');
    Route::get('interview-done/{id}', 'interviewDone');

});





Route::prefix('appointment')->controller(AppointmentFormController::class)->group(function () {
    Route::get('list-slots', 'listSlots');
    Route::get('position-detail/{id}', 'PositionDetail');
    Route::post('create', 'store');
    Route::post('check-existence', 'existingAppointment');
});


Route::apiResource('positions', PositionController::class);
Route::post('positions/change-status/{id}', [PositionController::class, 'changeStatus']);
 });
