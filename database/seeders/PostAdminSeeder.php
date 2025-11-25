<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostAdmin;

class PostAdminSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'content' => 'Pengumuman maintenance sistem pada jam 22.00',
                'author' => 'admin',
                'status' => 'published',
            ],
            [
                'content' => 'Update fitur dashboard baru untuk pengguna premium',
                'author' => 'moderator',
                'status' => 'draft',
            ],
            [
                'content' => 'Panduan keamanan akun untuk semua user',
                'author' => 'admin',
                'status' => 'published',
            ],
            [
                'content' => 'Event webinar gratis minggu depan!',
                'author' => 'admin2',
                'status' => 'pending',
            ],
            [
                'content' => 'Pembaruan kebijakan privasi',
                'author' => 'superadmin',
                'status' => 'published',
            ],
        ];

        foreach ($posts as $post) {
            PostAdmin::create($post);
        }
    }
}
