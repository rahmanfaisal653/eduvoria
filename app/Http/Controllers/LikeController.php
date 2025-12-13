<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\Notification; // ✅ TAMBAHAN
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        
        $like = Like::where('user_id', Auth::id())
                   ->where('post_id', $postId)
                   ->first();
        
        if ($like) {
            // =========================
            // HAPUS LIKE
            // =========================
            $like->delete();

            // decrement counter (tidak boleh minus)
            if ($post->likes_count > 0) {
                $post->decrement('likes_count');
            }

            return redirect()->back()->with('success', 'Like dihapus!');

        } else {
            // =========================
            // TAMBAH LIKE
            // =========================
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $postId
            ]);

            $post->increment('likes_count');

            // =========================
            // ✅ NOTIFIKASI (TAMBAHAN)
            // =========================
            // ❗ tidak buat notif kalau like postingan sendiri
            if ($post->user_id != Auth::id()) {

                // (opsional) cegah spam notif like berulang
                $alreadyNotif = Notification::where('user_id', $post->user_id)
                    ->where('from_user_id', Auth::id())
                    ->where('type', 'like')
                    ->where('reference_id', $post->id)
                    ->exists();

                if (!$alreadyNotif) {
                    Notification::create([
                        'user_id' => $post->user_id,      // penerima (pemilik post)
                        'from_user_id' => Auth::id(),     // pelaku like
                        'type' => 'like',
                        'reference_id' => $post->id,
                        'is_read' => false,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Post disukai!');
        }
    }
}
