<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class bookmarkController extends Controller
{
    public function index()
    {
        // Get all bookmarked posts for current user
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->with(['post.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.bookmark', compact('bookmarks'));
    }

    public function toggle(Request $request, $postId)
    {
        $user = Auth::user();
        
        // Check if bookmark already exists
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('post_id', $postId)
            ->first();

        if ($bookmark) {
            // Remove bookmark
            $bookmark->delete();
            return response()->json(['status' => 'removed', 'message' => 'Bookmark dihapus']);
        } else {
            // Add bookmark
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $postId
            ]);
            return response()->json(['status' => 'added', 'message' => 'Bookmark ditambahkan']);
        }
    }
}