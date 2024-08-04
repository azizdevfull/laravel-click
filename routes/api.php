<?php

use App\Http\Controllers\ClickController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/prepare', [ClickController::class, 'prepare']);
Route::post('/completed', [ClickController::class, 'complete']);