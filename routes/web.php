<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\bookmarkController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/homepage', [homepageController::class, 'index'])->name('homepage');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // 1. DASHBOARD ADMIN (Name: admin.dashboard)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. MANAGEMENT USERS (Name: admin.users)  
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users');

    // 3. CONTENT & POSTINGAN (Name: admin.content)
    Route::get('/content', [AdminController::class, 'contentIndex'])->name('content');

    // 4. LAPORAN & PELANGGARAN (Name: admin.reports.*)
    Route::get('/reports/content', [AdminController::class, 'reportsContentIndex'])->name('reports');

    Route::get('/reports/subscribe', [AdminController::class, 'reportsSubscribeIndex'])->name('subscribe');

    // 5. PENGATURAN SISTEM (Name: admin.settings)
    Route::get('/settings', function () {
        // Konten placeholder untuk Pengaturan Sistem
        return view('admin.settings.index');
    })->name('settings');

});

Route::get('/komunitas', [CommunityController::class, 'index'])->name('komunitas');
Route::get('/komunitas/create', [CommunityController::class, 'create'])->name('komunitas.create');
Route::get('/komunitas/diskusi', [CommunityController::class, 'diskusi'])
    ->name('komunitas.diskusi');
Route::get('/statistik', [StatisticsController::class, 'index'])->name('statistik');
Route::redirect('/statistic', '/statistik');
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [profileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [profileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [profileController::class, 'updateProfile'])->name('profile.update');
    
    // Post Routes
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Bookmark Routes
    Route::get('/bookmark', [bookmarkController::class, 'index'])->name('bookmark');
    Route::post('/bookmark/toggle/{postId}', [bookmarkController::class, 'toggle'])->name('bookmark.toggle');
});
