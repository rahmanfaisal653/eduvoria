<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\bookmarkController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\CommunityEventController;


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

// === AUTH ===
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // simulasi berhasil login
    return redirect()->route('homepage');
})->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // simulasi register -> redirect ke login
    return redirect()->route('login');
})->name('register.submit');


Route::redirect('/', '/homepage');
Route::get('/homepage', [homepageController::class, 'index'])->name('homepage');
Route::group(['prefix' => 'admin', 'as' => 'admin.
















'], function () {
    
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

route::get('/bookmark',[bookmarkController::class,'bookmark'])->name('bookmark');

Route::get('/profile', [profileController::class, 'profile'])->name('profile');
Route::get('/posts/create', [profileController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [profileController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}/edit', [profileController::class, 'edit'])->name('posts.edit');
Route::post('/posts/{id}/update', [profileController::class, 'update'])->name('posts.update');
Route::get('/posts/{id}/delete', [profileController::class, 'destroy'])->name('posts.destroy');
Route::get('/profile/edit', [profileController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update', [profileController::class, 'updateProfile'])->name('profile.update');
