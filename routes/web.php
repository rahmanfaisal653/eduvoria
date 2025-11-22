<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\PostAdminController;
use App\Http\Controllers\ReportAdminController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\bookmarkController;
use App\Http\Controllers\UserReportController;

use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\CommunityEventController;


use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

// use App\Http\Controllers\CommunityPostController;
// use App\Http\Controllers\CommunityEventController;



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

// Admin Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // 1. DASHBOARD ADMIN (Name: admin.dashboard)
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ==============================================================
    // 2. MANAGEMENT USERS (DIPERBARUI)
    // ==============================================================
    // Route untuk menampilkan tabel (GET)
    // Mengarah ke UserAdminController method usersindex
    Route::get('/users', [UserAdminController::class, 'usersindex'])->name('users');

    // Route untuk memproses form tambah user (POST)
    // Ini yang dipanggil di form action="{{ route('admin.users.store') }}"
    Route::post('/users/store', [UserAdminController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserAdminController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserAdminController::class, 'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserAdminController::class, 'destroy'])->name('users.delete');

    // ==============================================================


    // 3. CONTENT & POSTINGAN (Name: admin.content)
    Route::get('/content', [PostAdminController::class, 'contentIndex'])->name('content');

    Route::post('/content/store', [PostAdminController::class, 'store'])->name('content.store');
    Route::get('/content/edit/{id}', [PostAdminController::class, 'edit'])->name('content.edit');
    Route::post('/content/update/{id}', [PostAdminController::class, 'update'])->name('content.update');
    Route::get('/content/delete/{id}', [PostAdminController::class, 'destroy'])->name('content.delete');

    // 4. LAPORAN CONTENT (Name: admin.reports)
    Route::get('/reports/content', [ReportAdminController::class, 'reportsContentIndex'])->name('reports');

    Route::post('/reports/content/store', [ReportAdminController::class, 'store'])->name('reports.store');
    Route::get('/reports/content/edit/{id}', [ReportAdminController::class, 'edit'])->name('reports.edit');
    Route::post('/reports/content/update/{id}', [ReportAdminController::class, 'update'])->name('reports.update');
    Route::get('/reports/content/delete/{id}', [ReportAdminController::class, 'destroy'])->name('reports.delete');


    // 5. LAPORAN SUBSCRIBE (Name: admin.subscribe)
    // Route::get('/reports/subscribe', [AdminController::class, 'reportsSubscribeIndex'])->name('subscribe');

    // 5. PENGATURAN SISTEM
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings');

});

Route::post('/report/submit', [UserReportController::class, 'store'])->name('user.report.store');

Route::get('/komunitas', [CommunityController::class, 'index'])->name('komunitas.index');

// FORM BUAT KOMUNITAS
Route::get('/komunitas/create', [CommunityController::class, 'create'])->name('komunitas.create');

// SIMPAN KOMUNITAS
Route::post('/komunitas', [CommunityController::class, 'store'])->name('komunitas.store');

// HALAMAN DETAIL KOMUNITAS (komunitasdiskusi.blade.php)
Route::get('/komunitas/{id}', [CommunityController::class, 'show'])->name('komunitas.show');

// FORM EDIT KOMUNITAS
Route::get('/komunitas/{id}/edit', [CommunityController::class, 'edit'])->name('komunitas.edit');

// UPDATE KOMUNITAS
Route::put('/komunitas/{id}', [CommunityController::class, 'update'])->name('komunitas.update');

// HAPUS KOMUNITAS
Route::delete('/komunitas/{id}', [CommunityController::class, 'destroy'])->name('komunitas.destroy');

Route::post('/komunitas/{communityId}/post', [CommunityPostController::class, 'store'])
    ->name('community-posts.store');

// EDIT form
Route::get('/komunitas/{communityId}/post/{id}/edit', [CommunityPostController::class, 'edit'])
    ->name('community-posts.edit');

// UPDATE postingan
Route::put('/komunitas/{communityId}/post/{id}', [CommunityPostController::class, 'update'])
    ->name('community-posts.update');

// DELETE postingan
Route::delete('/komunitas/{communityId}/post/{id}', [CommunityPostController::class, 'destroy'])
    ->name('community-posts.destroy');

Route::get('/kalender-acara', [CommunityEventController::class, 'index'])
    ->name('kalender.index');

// Tambah acara dari halaman detail komunitas
Route::post('/komunitas/{communityId}/events', [CommunityEventController::class, 'store'])
    ->name('community-events.store');

// Edit acara
Route::get('/komunitas/{communityId}/events/{id}/edit', [CommunityEventController::class, 'edit'])
    ->name('community-events.edit');

// Update acara
Route::put('/komunitas/{communityId}/events/{id}', [CommunityEventController::class, 'update'])
    ->name('community-events.update');

// Hapus acara
Route::delete('/komunitas/{communityId}/events/{id}', [CommunityEventController::class, 'destroy'])
    ->name('community-events.destroy');

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
