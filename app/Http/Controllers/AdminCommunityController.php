<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage; // ✅ tambahan
use Illuminate\Support\Str;

class AdminCommunityController extends Controller
{
    /**
     * ✅ tambahan helper: simpan file ke storage/public/komunitas
     * tapi tetap bikin file name yang aman & unik.
     */
    private function storeToPublicKomunitas(UploadedFile $file): string
    {
        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->storeAs('komunitas', $filename, 'public'); // storage/app/public/komunitas
        return $filename;
    }

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

        /**
         * ✅ tambahan:
         * - kita simpan juga ke storage/public/komunitas (yang dipakai asset('storage/...'))
         * - tetap support cara lama move() ke public/uploads/komunitas (kalau kamu masih butuh)
         * - data DB kita set ke filename yang sama supaya view admin/user konsisten.
         */

        // ganti foto profil jika diupload
        if ($request->hasFile('profile_image')) {

            // ✅ simpan ke storage link (yang kamu mau)
            $profile = $this->storeToPublicKomunitas($request->file('profile_image'));
            $data['profile_image'] = $profile;

            // ✅ tetap jalankan cara lama juga (tanpa menghapus)
            // (kalau kamu gak butuh, biarkan tetap ada supaya tidak mengubah struktur lama)
            try {
                $request->file('profile_image')->move($uploadPath, $profile);
            } catch (\Throwable $e) {
                // biarin aja kalau gagal (misal file sudah kepindah / permission), yang penting storage sudah ada
            }
        }

        // ganti background jika diupload
        if ($request->hasFile('background_image')) {

            // ✅ simpan ke storage link
            $bg = $this->storeToPublicKomunitas($request->file('background_image'));
            $data['background_image'] = $bg;

            // ✅ tetap jalankan cara lama juga
            try {
                $request->file('background_image')->move($uploadPath, $bg);
            } catch (\Throwable $e) {
                // biarin aja
            }
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
