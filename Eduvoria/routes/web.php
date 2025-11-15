<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityController;
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

Route::get('/', function () {
    return view('welcome');
});

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

 // KOMUNITAS (Name: komunitas)
// halaman user komunitas (tanpa prefix admin)
Route::get('/komunitas', [CommunityController::class, 'index'])->name('user.komunitas');



