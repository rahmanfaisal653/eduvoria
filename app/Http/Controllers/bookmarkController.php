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
        
        $bookmark = Bookmark::where('user_id', Auth::id())
                           ->where('post_id', $postId)
                           ->first();
        
      
        if ($bookmark) {
            $bookmark->delete();
            return redirect()->back()->with('success', 'Bookmark dihapus!');
        } else {
            $bookmark = new Bookmark;
            $bookmark->user_id = Auth::id();
            $bookmark->post_id = $postId;
            $bookmark->save();
            return redirect()->back()->with('success', 'Bookmark ditambahkan!');
        }
    }
}