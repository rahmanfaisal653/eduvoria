<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\PostAdminController;
use App\Http\Controllers\ReportAdminController;
use App\Http\Controllers\SubcribeAdminController;
use App\Http\Controllers\SubcribeUserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\AdminCommunityController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\CommunityEventController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\bookmarkController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommunityMemberController;
use App\Http\Controllers\SearchController;


Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/homepage', [homepageController::class, 'index'])->name('homepage');

    // Search
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // Follow
    Route::post('/follow/{user}', [FollowController::class, 'toggle'])->name('follow.toggle');

    Route::get('/profile', [profileController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}', [profileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [profileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [profileController::class, 'updateProfile'])->name('profile.update');


    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}/delete', [PostController::class, 'destroy'])->name('posts.destroy');


    Route::get('/bookmark', [bookmarkController::class, 'index'])->name('bookmark');
    Route::post('/bookmark/toggle/{postId}', [bookmarkController::class, 'toggle'])->name('bookmark.toggle');

    Route::post('/like/toggle/{postId}', [App\Http\Controllers\LikeController::class, 'toggle'])->name('like.toggle');

    Route::post('/posts/{postId}/reply', [App\Http\Controllers\ReplyController::class, 'store'])->name('replies.store');
    Route::delete('/replies/{id}', [App\Http\Controllers\ReplyController::class, 'destroy'])->name('replies.destroy');
});

// Admin Routes
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth'], // <-- DITAMBAH: admin area wajib login
], function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

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

    Route::post('/reports/content/update/{id}', [ReportAdminController::class, 'update'])->name('reports.update');
    Route::get('/reports/content/delete/{id}', [ReportAdminController::class, 'destroy'])->name('reports.delete');


    // 5. LAPORAN SUBSCRIBE (Name: admin.subscribe)
    Route::get('/reports/subscribe', [SubcribeAdminController::class, 'reportsSubscribeIndex'])->name('subscribe');

    Route::post('reports/subscribe/update/{id}', [SubcribeAdminController::class, 'update'])->name('subscribe.update');
    Route::post('reports/subscribe/delete/{id}', [SubcribeAdminController::class, 'destroy'])->name('subscribe.destroy');

    // 5. PENGATURAN SISTEM
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings');

    Route::get('/komunitas', [AdminCommunityController::class, 'index'])
        ->name('komunitas.index');

    // Detail komunitas
    Route::get('/komunitas/{id}', [AdminCommunityController::class, 'show'])
        ->name('komunitas.show');

    // Form edit komunitas
    Route::get('/komunitas/{id}/edit', [AdminCommunityController::class, 'edit'])
        ->name('komunitas.edit');

    // Update komunitas
    Route::put('/komunitas/{id}', [AdminCommunityController::class, 'update'])
        ->name('komunitas.update');

    // Hapus komunitas
    Route::delete('/komunitas/{id}', [AdminCommunityController::class, 'destroy'])
        ->name('komunitas.destroy');

});

Route::post('/subscribe/store', [SubcribeUserController::class, 'store'])->name('user.subscribe.store');

Route::post('/report/submit', [UserReportController::class, 'store'])->name('user.report.store');

Route::get('/komunitas', [CommunityController::class, 'index'])->name('komunitas.index');

// FORM BUAT KOMUNITAS
Route::get('/komunitas/create', [CommunityController::class, 'create'])
    ->name('komunitas.create')
    ->middleware('auth'); // <-- bikin komunitas wajib login

// SIMPAN KOMUNITAS
Route::post('/komunitas', [CommunityController::class, 'store'])
    ->name('komunitas.store')
    ->middleware('auth'); // <-- simpan komunitas wajib login

   // ====== KOMUNITAS: JOIN & LEAVE ======
Route::post('/komunitas/{id}/join', [CommunityMemberController::class, 'join'])
    ->name('community.join')
    ->middleware('auth');

Route::post('/komunitas/{id}/leave', [CommunityMemberController::class, 'leave'])
    ->name('community.leave')
    ->middleware('auth');
    
// HALAMAN DETAIL KOMUNITAS (komunitasdiskusi.blade.php)
Route::get('/komunitas/{id}', [CommunityController::class, 'show'])->name('komunitas.show');

// FORM EDIT KOMUNITAS
Route::get('/komunitas/{id}/edit', [CommunityController::class, 'edit'])
    ->name('komunitas.edit')
    ->middleware('auth'); // <-- edit komunitas wajib login

// UPDATE KOMUNITAS
Route::put('/komunitas/{id}', [CommunityController::class, 'update'])
    ->name('komunitas.update')
    ->middleware('auth'); // <-- update wajib login

// HAPUS KOMUNITAS
Route::delete('/komunitas/{id}', [CommunityController::class, 'destroy'])
    ->name('komunitas.destroy')
    ->middleware('auth'); // <-- hapus wajib login

Route::post('/komunitas/{communityId}/post', [CommunityPostController::class, 'store'])
    ->name('community-posts.store')
    ->middleware('auth'); // <-- bikin postingan komunitas wajib login

// EDIT form
Route::get('/komunitas/{communityId}/post/{id}/edit', [CommunityPostController::class, 'edit'])
    ->name('community-posts.edit')
    ->middleware('auth'); // <-- edit post komunitas wajib login

// UPDATE postingan
Route::put('/komunitas/{communityId}/post/{id}', [CommunityPostController::class, 'update'])
    ->name('community-posts.update')
    ->middleware('auth'); // <-- update post wajib login

// DELETE postingan
Route::delete('/komunitas/{communityId}/post/{id}', [CommunityPostController::class, 'destroy'])
    ->name('community-posts.destroy')
    ->middleware('auth'); // <-- hapus post wajib login

Route::get('/kalender-acara', [CommunityEventController::class, 'index'])
    ->name('kalender.index')
    ->middleware('auth'); // <-- kalender acara pribadi wajib login

// Tambah acara dari halaman detail komunitas
Route::post('/komunitas/{communityId}/events', [CommunityEventController::class, 'store'])
    ->name('community-events.store')
    ->middleware('auth'); // <-- tambah event wajib login

// Edit acara
Route::get('/komunitas/{communityId}/events/{id}/edit', [CommunityEventController::class, 'edit'])
    ->name('community-events.edit')
    ->middleware('auth'); // <-- edit event wajib login

// Update acara
Route::put('/komunitas/{communityId}/events/{id}', [CommunityEventController::class, 'update'])
    ->name('community-events.update')
    ->middleware('auth'); // <-- update event wajib login

// Hapus acara
Route::delete('/komunitas/{communityId}/events/{id}', [CommunityEventController::class, 'destroy'])
    ->name('community-events.destroy')
    ->middleware('auth'); // <-- hapus event wajib login

// ====== EVENT: TAMBAH / HAPUS KE KALENDER PRIBADI (OPT-IN) ======
Route::post('/komunitas/{communityId}/events/{eventId}/add-to-calendar', [CommunityEventController::class, 'addToCalendar'])
    ->name('community-events.addToCalendar')
    ->middleware('auth');

Route::delete('/komunitas/{communityId}/events/{eventId}/remove-from-calendar', [CommunityEventController::class, 'removeFromCalendar'])
    ->name('community-events.removeFromCalendar')
    ->middleware('auth');


// ====== EVENT: TAMBAH / HAPUS DARI KALENDER PRIBADI ======
Route::post(
    '/komunitas/{communityId}/events/{id}/add-to-calendar',
    [CommunityEventController::class, 'addToCalendar']
)->name('community-events.add-to-calendar')
 ->middleware('auth');

Route::delete(
    '/komunitas/{communityId}/events/{id}/remove-from-calendar',
    [CommunityEventController::class, 'removeFromCalendar']
)->name('community-events.remove-from-calendar')
 ->middleware('auth');

Route::get('/statistik', [StatisticsController::class, 'index'])->name('statistik');
Route::redirect('/statistic', '/statistik');

Route::middleware(['auth'])->group(function () {

    // notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAll'])->name('notifikasi.readAll');
    Route::post('/notifikasi/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifikasi.read');

    // like
    Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])->name('posts.like');

    // comment
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');

    // follow
    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])->name('users.follow');
    
    Route::post('/notifikasi/read-all-ajax', [NotificationController::class, 'markAllAjax'])
        ->name('notifikasi.readAllAjax');

    Route::delete('/notifikasi/{id}', [NotificationController::class, 'destroy'])
        ->name('notifikasi.delete');
});