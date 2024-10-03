<?php

use App\Http\Controllers\SlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('slots',SlotController::class);
Route::post('slots/change-status/{id}', [SlotController::class, 'changeStatus']);

