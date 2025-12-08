<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
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
            // Hapus like dan decrement counter (tidak boleh minus)
            $like->delete();
            if ($post->likes_count > 0) {
                $post->decrement('likes_count');
            }
            return redirect()->back()->with('success', 'Like dihapus!');
        } else {
            // Tambah like dan increment counter
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $postId
            ]);
            $post->increment('likes_count');
            return redirect()->back()->with('success', 'Post disukai!');
        }
    }
}
