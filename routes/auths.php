<?php


use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Route;

//user auth routes
Route::prefix('user')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
