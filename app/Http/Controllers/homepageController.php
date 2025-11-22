<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class homepageController extends Controller
{
    public function index()
    {
        // Load all posts from database with user relationship, ordered by newest first
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return view('users.homepage', compact('posts'));
    }
}
