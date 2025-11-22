<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
        /**
     * Menampilkan Dashboard Admin dengan data metrik, tugas, dan log aktivitas.
     */
    public function dashboard()
    {
        // Data metrik utama dashboard (Jika Anda ingin mengirimnya secara dinamis, tambahkan di sini)
        // Saat ini metrik utama statis ada di dashboard.blade.php.

        // Data Tugas Prioritas
        $tasks = [
            [
                'title' => 'Review 5 Postingan yang Dilaporkan',
                'subtitle' => 'Pelanggaran SARA',
                'route' => route('admin.reports'), // Sesuaikan dengan nama route Anda
                'color_class' => 'text-red-600',
                'button_color' => 'red',
                'action' => 'Tindak',
            ],
            [
                'title' => 'Verifikasi 2 Akun Pengguna Baru',
                'subtitle' => 'Verifikasi Bisnis',
                'route' => route('admin.users'), // Sesuaikan dengan nama route Anda
                'color_class' => 'text-cyan-600',
                'button_color' => 'cyan',
                'action' => 'Lihat',
            ],
            [
                'title' => 'Balas Pertanyaan Komunitas',
                'subtitle' => 'Grup Fotografi Alam',
                'route' => route('admin.content'), // Sesuaikan dengan nama route Anda
                'color_class' => 'text-teal-600',
                'button_color' => 'teal',
                'action' => 'Buka',
            ],
        ];

        // Data Log Aktivitas Terbaru
        $logs = [
            [
                'description' => "Akun 'Joko S' <span class='text-green-600'>diaktifkan</span>.",
                'admin' => 'D. Lestari',
                'time' => '10:30 WIB',
                'color' => 'green',
            ],
            [
                'description' => "Postingan [ID: 7823] <span class='text-red-600'>dihapus</span>.",
                'admin' => 'R. Pratama',
                'time' => '09:15 WIB',
                'color' => 'red',
            ],
            [
                'description' => "Pengaturan sistem <span class='text-cyan-600'>diperbarui</span>.",
                'admin' => 'R. Pratama',
                'time' => '08:00 WIB',
                'color' => 'cyan',
            ],
        ];

        return view('admin.dashboard', compact('tasks', 'logs'));
    }

    public function contentIndex()
    {
        // Data Postingan Admin (Simulasi)
        $posts = [
            [
                'id' => 4589,
                'content' => 'Liburan singkat ke pegunungan. Udara segar dan pemandangan indah Sempurna untuk mengisi ulang energi. 🙏',
                'author' => 'Budi Santoso',
                'status' => 'Tayang',
                'status_color' => 'bg-green-100 text-green-800'
            ],
            [
                'id' => 4590,
                'content' => 'Tips investasi kripto yang bisa bikin kaya mendadak, ayo gabung grup VVIP!',
                'author' => 'Anonim23',
                'status' => 'Dilaporkan',
                'status_color' => 'bg-red-100 text-red-800'
            ],
            [
                'id' => 4591,
                'content' => 'Bagaimana cara terbaik untuk belajar framework Laravel 11 dengan cepat?',
                'author' => 'Ahmad R.',
                'status' => 'Tayang',
                'status_color' => 'bg-green-100 text-green-800'
            ]
        ];

        return view('admin.content', compact('posts'));
    }

    public function reportsContentIndex()
    {
        $reports = [
            [
                'id' => 'RPT-905',
                'type' => 'Ujaran Kebencian',
                'target' => 'Postingan #4599',
                'priority' => 'Tinggi',
                'priority_color' => 'bg-red-100 text-red-800',
                'content_summary' => 'Komentar mengandung ancaman serius terhadap pengguna lain.'
            ],
            [
                'id' => 'RPT-906',
                'type' => 'Pelanggaran Privasi',
                'target' => 'Akun Budi S.',
                'priority' => 'Tinggi',
                'priority_color' => 'bg-red-100 text-red-800',
                'content_summary' => 'Postingan menyebarkan informasi pribadi tanpa persetujuan.'
            ],
            [
                'id' => 'RPT-907',
                'type' => 'Konten Tidak Pantas',
                'target' => 'Postingan #4601',
                'priority' => 'Sedang',
                'priority_color' => 'bg-yellow-100 text-yellow-800',
                'content_summary' => 'Gambar/teks berpotensi vulgar, perlu tinjauan manual.'
            ],
            [
                'id' => 'RPT-908',
                'type' => 'Spam Berulang',
                'target' => 'Akun \'Promo2026\'',
                'priority' => 'Sedang',
                'priority_color' => 'bg-yellow-100 text-yellow-800',
                'content_summary' => 'Akun ini memposting tautan afiliasi yang sama lebih dari 10 kali dalam satu jam.'
            ],
            [
                'id' => 'RPT-909',
                'type' => 'Pelanggaran Hak Cipta',
                'target' => 'Video/Musik',
                'priority' => 'Rendah',
                'priority_color' => 'bg-green-100 text-green-800',
                'content_summary' => 'Klaim penggunaan klip musik berhak cipta pada video.'
            ],
        ];

        return view('admin.reports_content', compact('reports'));
    }
    
    // --- METODE LAPORAN SUBSCRIBE ---
    public function reportsSubscribeIndex()
    {
        $subsReports = [
            [
                'id' => 'SUB-1003',
                'user' => 'Budi Santoso',
                'type' => 'Pembayaran Gagal',
                'date' => '15 Okt 2025',
                'status' => 'Gagal',
                'status_color' => 'bg-red-100 text-red-800'
            ],
            [
                'id' => 'SUB-1004',
                'user' => 'Sinta Wijaya',
                'type' => 'Upgrade Gagal',
                'date' => '17 Okt 2025',
                'status' => 'Pending',
                'status_color' => 'bg-yellow-100 text-yellow-800'
            ],
        ];

        return view('admin.subscribe', compact('subsReports'));
    }
}
