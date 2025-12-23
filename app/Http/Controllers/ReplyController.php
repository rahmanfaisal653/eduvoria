<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Post;               // ✅ TAMBAHAN
use App\Models\Notification;       // ✅ TAMBAHAN
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // Simpan reply baru
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        // ✅ TAMBAHAN: ambil post untuk tahu pemilik post
        $post = Post::findOrFail($postId);

        $reply = new Reply;
        $reply->post_id = $postId;
        $reply->user_id = Auth::id();
        $reply->content = $request['content'];
        $reply->save();

  
        // NOTIFIKASI (TAMBAHAN)
        // tidak buat notif kalau reply ke postingan sendiri
        if ($post->user_id != Auth::id()) {

            // (opsional) cegah spam notifikasi reply/comment yang sama persis
            // kamu boleh hapus blok ini kalau mau setiap reply selalu bikin notif
            $alreadyNotif = Notification::where('user_id', $post->user_id)
                ->where('from_user_id', Auth::id())
                ->where('type', 'comment') // atau 'reply' kalau kamu mau bedain
                ->where('reference_id', $reply->id)
                ->exists();

            if (!$alreadyNotif) {
                Notification::create([
                    'user_id' => $post->user_id,      // penerima (pemilik post)
                    'from_user_id' => Auth::id(),     // pelaku reply
                    'type' => 'comment',              // atau 'reply'
                    'reference_id' => $reply->id,     // id reply agar bisa dilacak
                    'is_read' => false,
                ]);
            }
        }

        // Set flag untuk skip view count saat redirect kembali ke postingan
        session()->put('skip_view_count_' . $postId, true);
        
        return redirect()->back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    // Hapus reply
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);

     
        if ($reply->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus balasan orang lain!');
        }

        $reply->delete();

        return redirect()->back()->with('success', 'Balasan berhasil dihapus!');
    }
}
