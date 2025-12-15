<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return redirect()->route('homepage');
        }

        // Search users
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('bio', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        // Search posts
        $posts = Post::where('content', 'LIKE', "%{$query}%")
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('users.search-results', compact('query', 'users', 'posts'));
    }
}
