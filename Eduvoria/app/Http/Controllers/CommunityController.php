<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = [
            [
                'name' => 'Desain UI/UX',
                'members' => 2540,
                'description' => 'Tempat belajar dan berbagi seputar desain antarmuka dan pengalaman pengguna.',
                'image' => 'https://source.unsplash.com/300x200/?uiux,design',
            ],
            [
                'name' => 'Pemrograman Web',
                'members' => 3120,
                'description' => 'Komunitas bagi pengembang web front-end dan back-end untuk berbagi proyek dan ide.',
                'image' => 'https://source.unsplash.com/300x200/?web,code',
            ],
            [
                'name' => 'Data Science',
                'members' => 1980,
                'description' => 'Diskusikan machine learning, analisis data, dan AI bersama anggota lainnya.',
                'image' => 'https://source.unsplash.com/300x200/?data,science',
            ],
            [
                'name' => 'Digital Marketing',
                'members' => 1750,
                'description' => 'Pelajari strategi pemasaran digital dan berbagi tips kampanye sukses.',
                'image' => 'https://source.unsplash.com/300x200/?marketing,digital',
            ],
        ];

        // arahkan ke folder componentsUser
        return view('componentsUser.komunitas', compact('communities'));
    }
}
