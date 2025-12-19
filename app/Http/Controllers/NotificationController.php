<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use App\Models\Reply;
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

    // =========================
    // BUKA NOTIFIKASI (CLICK)
    // - otomatis tandai dibaca
    // - redirect ke target (post/reply/profile)
    // =========================
    public function open($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$notif->is_read) {
            $notif->update(['is_read' => true]);
        }

        switch ($notif->type) {
            case 'like':
                // reference_id = post_id
                if ($notif->reference_id && Post::whereKey($notif->reference_id)->exists()) {
                    return redirect()->route('posts.show', $notif->reference_id);
                }
                break;

            case 'comment':
                // reference_id = reply_id
                if ($notif->reference_id) {
                    $reply = Reply::find($notif->reference_id);
                    if ($reply && $reply->post_id && Post::whereKey($reply->post_id)->exists()) {
                        return redirect()->route('posts.show', $reply->post_id);
                    }
                }
                break;

            case 'follow':
                if ($notif->from_user_id) {
                    return redirect()->route('profile.show', $notif->from_user_id);
                }
                break;
        }

        return redirect()->route('notifikasi');
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

    
    public function destroy(Request $request, $id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->delete();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'deleted']);
        }

        return back()->with('success', 'Notifikasi dihapus.');
    }
}
