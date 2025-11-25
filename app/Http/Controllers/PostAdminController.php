<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostAdminController extends Controller
{
    public function contentIndex()
    {
        $posts = Post::with('user')->get();
        return view('admin.content', compact('posts'));
    }

    public function create()
    {
        return view('componentsAdmin.add-post-modal');
    }

    public function store(Request $request)
    {
        $imagePath = null;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        
        $staticAdminId = 1; 

        Post::create([
            'user_id' => $staticAdminId, 
            'content' => $request->content,
            'image' => $imagePath, 
            'status' => $request->status,
        ]);

        return redirect()->route('admin.content')->with('success', 'Post berhasil dibuat!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('componentsAdmin.edit-post-modal', compact('post'));
    }

    public function update(Request $request, $id)
    {

        $post = Post::findOrFail($id);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'content' => $request->content,
            'image' => $imagePath ?? $post->image, 
            'status' => $request->status,
        ]);

        return redirect()->route('admin.content');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.content');
    }
}
