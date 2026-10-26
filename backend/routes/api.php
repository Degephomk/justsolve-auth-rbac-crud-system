<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// -----------------------------------------------------------
// PUBLIC ROUTES
// -----------------------------------------------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


// -----------------------------------------------------------
// AUTHENTICATED USER ROUTES (auth:sanctum)
// -----------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Return the currently logged-in user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Project CRUD (policy protected)
    Route::apiResource('projects', ProjectController::class);


    // -------------------------------------------------------
    // ADMIN ROUTES (auth + isAdmin)
    // MUST be nested inside auth:sanctum group!
    // -------------------------------------------------------
    Route::middleware('isAdmin')->group(function () {
        Route::get('/admin/projects', [AdminController::class, 'index']);
    });
});
