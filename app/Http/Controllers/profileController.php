<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{
    public function profile()
    {
        // Data profil hardcode
        $profiles = [
            'nama' => 'Faisal',
            'hobi' => ['fotografi','sepak bola','catur'],
            'bio' => 'God is good',
            'pengikut' => '400k',
            'mengikuti' => '593',
            'postingan' => '213'
        ];

        // Postingan hardcode
        $profilePosts = [
            ['id' => 1, 'nama' => 'Faisal', 'waktu' => '5', 'isi' => 'jangan lupa kerjain pr guys', 'like' => '15k', 'komentar' => '2k'],
            ['id' => 2, 'nama' => 'Faisal', 'waktu' => '23', 'isi' => 'mama said im the best :)', 'like' => '50k', 'komentar' => '5k'],
        ];

        // Urutkan biar terbaru di atas
        $profilePosts = array_reverse($profilePosts);

        return view('users.profile', compact('profiles', 'profilePosts'));
    }

    public function create()
    {
        return view('users.postingan.create');
    }

    public function store(Request $request)
    {
        // Simulasi tambah postingan
        $newPost = [
            'id' => 3,
            'nama' => 'Faisal',
            'waktu' => '1',
            'isi' => $request->isi,
            'like' => '0',
            'komentar' => '0',
        ];

        // Redirect aja tanpa data baru (karena hardcode)
        return redirect('/profile')->with('success', 'Postingan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Hardcode contoh postingan yang sedang diedit
        $post = [
            'id' => $id,
            'nama' => 'Faisal',
            'isi' => 'Ini isi postingan contoh yang bisa diedit.'
        ];

        return view('users.postingan.editPostingan', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Tidak benar-benar mengubah data (karena hardcode)
        return redirect('/profile')->with('success', "Postingan ID {$id} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        // Tidak benar-benar menghapus (karena hardcode)
        return redirect('/profile')->with('success', "Postingan ID {$id} berhasil dihapus!");
    }

    public function editProfile()
    {
        $profile = [
            'nama' => 'Faisal',
            'bio' => 'God is good',
        ];
        return view('users.editProfile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        // Tidak benar-benar update (karena hardcode)
        return redirect('/profile')->with('success', 'Profil berhasil diperbarui (simulasi)!');
}
}