<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\CommunityApiController;
use App\Http\Controllers\Api\Admin\UserManagementApiController;

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

// Public routes (tidak perlu authentication)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (perlu authentication dengan Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    // ========== Authentication ==========
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // ========== Posts CRUD ==========
    Route::apiResource('posts', PostApiController::class);
    
    // ========== Communities CRUD ==========
    Route::apiResource('communities', CommunityApiController::class);
    
    // ========== Admin Routes (Admin Only) ==========
    Route::prefix('admin')->group(function () {
        // User Management
        Route::get('/users/stats', [UserManagementApiController::class, 'stats']);
        Route::post('/users/{id}/block', [UserManagementApiController::class, 'block']);
        Route::post('/users/{id}/unblock', [UserManagementApiController::class, 'unblock']);
        Route::apiResource('users', UserManagementApiController::class);
    });
    
    // Endpoint user info (backward compatibility)
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });
});