<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class homepageController extends Controller
{
    public function index()
    {
        // Load all posts with user, replies dan counter
        $posts = Post::with(['user', 'replies.user'])
            ->withCount('replies')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.homepage', compact('posts'));
    }
}
