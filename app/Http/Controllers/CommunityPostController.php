<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityPostController extends Controller
{
    // SIMPAN POSTINGAN BARU
    public function store(Request $request, $communityId)
    {
        $data = $request->validate([
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // pastikan komunitas ada
        $community = Community::findOrFail($communityId);

        // upload gambar (opsional)
        $uploadPath = public_path('uploads/postingan_komunitas');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move($uploadPath, $imageName);
            $data['image'] = $imageName;
        }

        $data['community_id'] = $community->id;
        $data['author_name']  = 'User'; // sementara, kalau belum pakai auth

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

        return view('users.komunitas.edit_post', compact('community', 'post'));
    }

    // UPDATE POSTINGAN
    public function update(Request $request, $communityId, $id)
    {
        $community = Community::findOrFail($communityId);
        $post = CommunityPost::where('community_id', $communityId)->findOrFail($id);

        $data = $request->validate([
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $uploadPath = public_path('uploads/postingan_komunitas');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move($uploadPath, $imageName);
            $data['image'] = $imageName;
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

        $post->delete();

        return redirect()
            ->route('komunitas.show', $community->id)
            ->with('success', 'Postingan berhasil dihapus.');
    }
}
