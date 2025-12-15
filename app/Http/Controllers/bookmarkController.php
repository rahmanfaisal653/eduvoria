<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class bookmarkController extends Controller
{
    public function index()
    {
      
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->with(['post.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.bookmark', compact('bookmarks'));
    }


    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        
        // Cek apakah user mencoba bookmark postingan sendiri
        if ($post->user_id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat bookmark postingan sendiri!');
        }
        
        $bookmark = Bookmark::where('user_id', Auth::id())
                           ->where('post_id', $postId)
                           ->first();
        
      
        if ($bookmark) {
            // Hapus bookmark dan decrement counter (tidak boleh minus)
            $bookmark->delete();
            if ($post->bookmarks_count > 0) {
                $post->decrement('bookmarks_count');
            }
            return redirect()->back()->with('success', 'Bookmark dihapus!');
        } else {
            // Tambah bookmark dan increment counter
            $bookmark = new Bookmark;
            $bookmark->user_id = Auth::id();
            $bookmark->post_id = $postId;
            $bookmark->save();
            $post->increment('bookmarks_count');
            return redirect()->back()->with('success', 'Bookmark ditambahkan!');
        }
    }
}