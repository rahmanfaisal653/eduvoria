<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create()
    {
        return view('users.postingan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imagePath = null;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
            'image' => $imagePath,
            'likes_count' => 0
        ]);

        return redirect()->route('homepage')->with('success', 'Postingan berhasil dibuat!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        
        // Check if user owns this post
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('profile')->with('error', 'Anda tidak memiliki akses untuk mengedit postingan ini.');
        }

        return view('users.postingan.editPostingan', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        

        if ($post->user_id !== Auth::id()) {
            return redirect()->route('profile')->with('error', 'Anda tidak memiliki akses untuk mengupdate postingan ini.');
        }

    
        $request->validate([
            'content' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        
        if ($request->hasFile('image')) {
           
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->content = $request['content'];
        $post->save();

        return redirect()->route('profile')->with('success', 'Postingan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('profile')->with('error', 'Anda tidak memiliki akses untuk menghapus postingan ini.');
        }


        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('profile')->with('success', 'Postingan berhasil dihapus!');
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        
        // Increment views
        $post->increment('views');
        
        return view('users.postingan.show', compact('post'));
    }
}
