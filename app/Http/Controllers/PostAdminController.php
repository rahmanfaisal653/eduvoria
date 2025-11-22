<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostAdmin;

class PostAdminController extends Controller
{
    public function contentIndex()
    {
        $posts = PostAdmin::all();
        return view('admin.content', compact('posts'));
    }

    public function create()
    {
        return view('componentsAdmin.add-post-modal');
    }

    public function store(Request $request)
    {
        PostAdmin::create([
            'content' => $request->content,
            'author' => $request->author,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.content');
    }

    public function edit($id)
    {
        $post = PostAdmin::findOrFail($id);
        return view('componentsAdmin.edit-post-modal', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = PostAdmin::findOrFail($id);
        $post->update([
            'content' => $request->content,
            'author' => $request->author,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.content');
    }

    public function destroy($id)
    {
        $post = PostAdmin::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.content');
    }
}
