<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $popularDiscussions = [
            [
                'title'    => 'Bagaimana cara mengoptimalkan kecepatan website dengan Tailwind?',
                'excerpt'  => 'Thread ini membahas teknik PurgeCSS dan optimasi lainnya untuk mengurangi ukuran file CSS di proyek Tailwind.',
                'topic'    => 'TechDesign',
                'is_hot'   => true,
                'comments' => 89,
                'author'   => 'Risa',
                'url'      => '#',
            ],
            [
                'title'    => 'Rekomendasi tempat liburan akhir tahun yang terjangkau',
                'excerpt'  => 'Bagi tips dan pengalaman Anda tentang destinasi liburan yang ramah anggaran di Indonesia.',
                'topic'    => 'JalanJalan',
                'is_hot'   => false,
                'comments' => 56,
                'author'   => 'Budi',
                'url'      => '#',
            ],
        ];

        $suggestedGroups = [
            ['name' => 'Fotografer Alam', 'members' => '2.1K', 'url' => '#', 'icon' => '📷'],
            ['name' => 'Pecinta Tanaman', 'members' => '800',  'url' => '#', 'icon' => '🪴'],
            ['name' => 'UI/UX Designer',  'members' => '4.5K', 'url' => '#', 'icon' => '💻'],
        ];

        $upcomingEvents = [
            ['title' => 'Workshop Desain Cepat', 'date' => 'Senin, 28 Okt', 'time' => '19:00 WIB', 'url' => '#'],
            ['title' => 'Meetup Traveling',      'date' => 'Sabtu, 2 Nov', 'time' => '10:00 WIB', 'url' => '#'],
        ];

        // arahkan ke folder resources/views/componentsUser/komunitas.blade.php
        return view('users.komunitas.komunitas', compact('popularDiscussions','suggestedGroups','upcomingEvents'));
    }
    
public function create()
{
    return view('users.komunitas.create'); 
}

public function saveDraft(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);
    return redirect()->route('komunitas')->with('success', 'Diskusi berhasil disimpan');
}

}
