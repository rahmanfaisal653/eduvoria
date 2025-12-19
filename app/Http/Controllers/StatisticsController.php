<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\Reply;

class StatisticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Kalau belum login, tampilkan 0 semua (halaman ini biasa diakses dari menu profile)
        if (!$userId) {
            $stats = [
                'followers' => 0,
                'views' => 0,
                'likes' => 0,
                'replies' => 0,
            ];

            $kpis = [
                ['title' => 'Pengikut', 'value' => 0],
                ['title' => 'Views Postingan', 'value' => 0],
                ['title' => 'Like Diterima', 'value' => 0],
                ['title' => 'Reply Diterima', 'value' => 0],
            ];

            return view('users.statistik', compact('kpis', 'stats'));
        }

        // "orang lain -> saya"
        $followersCount = Schema::hasTable('follows')
            ? Follow::where('following_id', $userId)->count()
            : 0;

        // total views semua postingan saya
        $viewsCount = (Schema::hasTable('posts') && Schema::hasColumn('posts', 'views'))
            ? (int) Post::where('user_id', $userId)->sum('views')
            : 0;

        // total like yang diterima postingan saya (exclude like dari diri sendiri)
        $likesReceivedCount = Schema::hasTable('likes')
            ? Like::where('user_id', '!=', $userId)
                ->whereHas('post', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->count()
            : 0;

        // total reply yang diterima postingan saya (exclude reply dari diri sendiri)
        $repliesReceivedCount = Schema::hasTable('replies')
            ? Reply::where('user_id', '!=', $userId)
                ->whereHas('post', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->count()
            : 0;

        $stats = [
            'followers' => $followersCount,
            'views' => $viewsCount,
            'likes' => $likesReceivedCount,
            'replies' => $repliesReceivedCount,
        ];

        $kpis = [
            ['title' => 'Pengikut', 'value' => $followersCount],
            ['title' => 'Views Postingan', 'value' => $viewsCount],
            ['title' => 'Like Diterima', 'value' => $likesReceivedCount],
            ['title' => 'Reply Diterima', 'value' => $repliesReceivedCount],
        ];

        return view('users.statistik', compact('kpis', 'stats'));
    }
}
