<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homepageController extends Controller
{
        public function index()
    {
        // Data Postingan Tiruan (Mock Data)
        // Struktur data disesuaikan dengan variabel yang digunakan di homepage.blade.php
        $posts = [
            [
                'id' => 101,
                'name' => 'Rifky Pratama',
                'user_slug' => 'rifky-pratama',
                'time' => '2 jam yang lalu',
                'content' => 'Menikmati sore yang cerah dengan secangkir kopi favorit. Apa rencana kalian hari ini?',
                'img_color' => 'orange-400', // Digunakan untuk warna avatar
                'img_src' => 'F28A25', // Digunakan untuk placeholder gambar
                'img_text' => 'Kopi+Sore', // Teks untuk placeholder gambar
                'likes' => 724,
                'comments' => 19,
            ],
            [
                'id' => 102,
                'name' => 'Dewi Lestari',
                'user_slug' => 'dewi-lestari',
                'time' => '5 jam yang lalu',
                'content' => 'Baru saja menyelesaikan proyek terkait banget logo dan tangga dengan hasilnya. Kerja keras selalu terbayar. 😉 #ProyekBaru #UIUX',
                'img_color' => 'pink-400',
                'img_src' => 'FFC0CB',
                'img_text' => 'Proyek+UIUX',
                'likes' => 285,
                'comments' => 30,
            ],
            [
                'id' => 103,
                'name' => 'Budi Santoso',
                'user_slug' => 'budi-santoso',
                'time' => '1 hari yang lalu',
                'content' => 'Liburan singkat ke pegunungan. Udara segar dan pemandangan indah Sempurna untuk mengisi ulang energi. 🙏 #Liburan #Gunung',
                'img_color' => 'blue-500',
                'img_src' => '2C5282',
                'img_text' => 'Pegunungan',
                'likes' => 512,
                'comments' => 89,
            ],
            [
                'id' => 104,
                'name' => 'Sinta Wijaya',
                'user_slug' => 'sinta-wijaya',
                'time' => '3 hari yang lalu',
                'content' => 'Akhirnya selesai juga membaca buku tentang arsitektur mikroservis. Siap untuk implementasi proyek berikutnya!',
                'img_color' => 'purple-500',
                'img_src' => '800080',
                'img_text' => 'Mikroservis',
                'likes' => 99,
                'comments' => 15,
            ],
        ];

        // Melewatkan data postingan ke view 'homepage'
        return view('users.homepage', [
            'posts' => $posts
        ]);
    }
}
