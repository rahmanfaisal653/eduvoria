<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Community;
use App\Models\CommunityMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityPostController extends Controller
{
    // SIMPAN POSTINGAN BARU
    public function store(Request $request, $communityId)
    {
        $user = Auth::user();
        $community = Community::findOrFail($communityId);

        $isOwner  = ($community->owner_id === $user->id);
        $isMember = CommunityMember::where('community_id', $community->id)
                                   ->where('user_id', $user->id)
                                   ->exists();

        if (!$isOwner && !$isMember) {
            abort(403, 'Kamu tidak punya akses membuat postingan di komunitas ini.');
        }

        $data = $request->validate([
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('postingan_komunitas', $filename, 'public');
            $data['image'] = $filename;
        }

        $data['community_id'] = $community->id;
        $data['author_name']  = $user->name;   // <— nama pembuat postingan

        CommunityPost::create($data);

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Postingan berhasil dibuat.');
    }

    // FORM EDIT POSTINGAN
    public function edit($communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $post = CommunityPost::where('community_id', $communityId)->findOrFail($id);

        $user = Auth::user();

        $isOwner  = ($community->owner_id === $user->id);
        $isAdmin  = ($user->role === 'admin');
        $isAuthor = ($post->author_name === $user->name);

        if (!$isOwner && !$isAdmin && !$isAuthor) {
            abort(403, 'Kamu tidak punya akses mengedit postingan ini.');
        }

        return view('users.komunitas.edit_post', compact('community', 'post'));
    }

    // UPDATE POSTINGAN
    public function update(Request $request, $communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $post = CommunityPost::where('community_id', $communityId)->findOrFail($id);

        $user = Auth::user();
        $isOwner  = ($community->owner_id === $user->id);
        $isAdmin  = ($user->role === 'admin');
        $isAuthor = ($post->author_name === $user->name);

        if (!$isOwner && !$isAdmin && !$isAuthor) {
            abort(403, 'Kamu tidak punya akses mengupdate postingan ini.');
        }

        $data = $request->validate([
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('postingan_komunitas', $filename, 'public');
            $data['image'] = $filename;
        }

        $post->update($data);

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Postingan berhasil diperbarui.');
    }

    // HAPUS POSTINGAN
    public function destroy($communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $post = CommunityPost::where('community_id', $communityId)->findOrFail($id);

        $user = Auth::user();
        $isOwner  = ($community->owner_id === $user->id);
        $isAdmin  = ($user->role === 'admin');
        $isAuthor = ($post->author_name === $user->name);

        if (!$isOwner && !$isAdmin && !$isAuthor) {
            abort(403, 'Kamu tidak punya akses menghapus postingan ini.');
        }

        $post->delete();

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Postingan berhasil dihapus.');
    }
}
