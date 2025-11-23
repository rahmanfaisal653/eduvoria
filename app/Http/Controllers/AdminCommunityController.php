<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCommunityController extends Controller
{
   
    public function index()
    {
        $communities = Community::orderBy('id', 'desc')->get();

       
        $totalCommunities = Community::count();
        $totalMembers     = Community::sum('members_count'); // jumlah anggota semua komunitas
        $needReview       = 0; // placeholder, nanti bisa dihubungkan dengan laporan

        return view('admin.komunitas.index', compact(
            'communities',
            'totalCommunities',
            'totalMembers',
            'needReview'
        ));
    }

    // ==========================
    // SHOW: DETAIL KOMUNITAS
    // ==========================
    public function show($id)
    {
        $community = Community::findOrFail($id);

        return view('admin.komunitas.show', compact('community'));
    }

    // ==========================
    // FORM EDIT KOMUNITAS
    // ==========================
    public function edit($id)
    {
        $community = Community::findOrFail($id);

        return view('admin.komunitas.edit', compact('community'));
    }

    // ==========================
    // UPDATE KOMUNITAS
    // ==========================
    public function update(Request $request, $id)
    {
        $community = Community::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:255',
            'members_count' => 'nullable|integer',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // folder upload
        $uploadPath = public_path('uploads/komunitas');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // ganti foto profil jika diupload
        if ($request->hasFile('profile_image')) {
            $profile = time().'_'.$request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move($uploadPath, $profile);
            $data['profile_image'] = $profile;
        }

        // ganti background jika diupload
        if ($request->hasFile('background_image')) {
            $bg = time().'_'.$request->file('background_image')->getClientOriginalName();
            $request->file('background_image')->move($uploadPath, $bg);
            $data['background_image'] = $bg;
        }

        // update slug sesuai nama
        $data['slug'] = Str::slug($data['name']);

        $community->update($data);

        return redirect()->route('admin.komunitas.index')
            ->with('success', 'Data komunitas berhasil diperbarui.');
    }

    // ==========================
    // HAPUS KOMUNITAS
    // ==========================
    public function destroy($id)
    {
        $community = Community::findOrFail($id);
        $community->delete();

        return redirect()->route('admin.komunitas.index')
            ->with('success', 'Komunitas berhasil dihapus.');
    }
}
