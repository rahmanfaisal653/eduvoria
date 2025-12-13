<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        // ✅ TAMBAHAN: normalisasi filter biar aman
        if (!in_array($filter, ['all', 'unread', 'read'])) {
            $filter = 'all';
        }

        $q = Notification::with('fromUser')
            ->where('user_id', auth()->id())
            ->latest();

        // =========================
        // FILTER (TETAP)
        // =========================
        if ($filter === 'unread') $q->where('is_read', false);
        if ($filter === 'read')   $q->where('is_read', true);

        $notifications = $q->paginate(20);

        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        // ✅ TAMBAHAN: totalCount & readCount untuk angka di tab
        $totalCount = Notification::where('user_id', auth()->id())->count();

        $readCount = Notification::where('user_id', auth()->id())
            ->where('is_read', true)
            ->count();

        return view('users.notifikasi', compact(
            'notifications',
            'unreadCount',
            'readCount',     // ✅ TAMBAHAN
            'totalCount',    // ✅ TAMBAHAN
            'filter'
        ));
    }

    // =========================
    // TANDAI 1 NOTIFIKASI
    // =========================
    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->update(['is_read' => true]);

        return back();
    }

    // =========================
    // TANDAI SEMUA (FORM / POST)
    // =========================
    public function markAll()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back();
    }

    // ==================================================
    // ➕ TAMBAHAN: MARK ALL VIA AJAX (UNTUK JS UI)
    // ==================================================
    public function markAllAjax()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    // ==================================================
    // ➕ TAMBAHAN: HAPUS 1 NOTIFIKASI (BTN ✕)
    // ==================================================
    public function destroy($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->delete();

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
