<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        // dummy data (bisa ganti dari DB nanti)
        $notifications = [
            ['type' => 'like',    'text' => 'Dewi menyukai postinganmu',           'time' => '2m',  'unread' => true],
            ['type' => 'comment', 'text' => 'Budi berkomentar: "Mantap!"',         'time' => '15m', 'unread' => true],
            ['type' => 'follow',  'text' => 'Risa mulai mengikuti kamu',           'time' => '1h',  'unread' => false],
            ['type' => 'system',  'text' => 'Perubahan kebijakan privasi berlaku', 'time' => '1d',  'unread' => false],
        ];

        // hitung unread untuk badge (opsional, kalau mau dipakai di header)
        $unreadCount = collect($notifications)->where('unread', true)->count();

        return view('users.notifikasi', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
        ]);
    }
}
