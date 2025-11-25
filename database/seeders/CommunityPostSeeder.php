<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommunityPost;

class CommunityPostSeeder extends Seeder
{
    public function run(): void
    {
        CommunityPost::create([
            'community_id' => 1,
            'author_name'  => 'Faisal Rahman',
            'content'      => 'Halo! Ini postingan pertama di komunitas Fotografer Alam.',
            'image'        => null,
        ]);

        CommunityPost::create([
            'community_id' => 1,
            'author_name'  => 'Siti Nurhaliza',
            'content'      => 'Berbagi foto lanskap terbaru saya! Bagaimana menurut kalian?',
            'image'        => 'lanskap1.jpg',
        ]);

        CommunityPost::create([
            'community_id' => 2,
            'author_name'  => 'Budi Pratama',
            'content'      => 'Tanaman monstera saya tumbuh subur! Ada yang mau tips rawatan?',
            'image'        => null,
        ]);

        CommunityPost::create([
            'community_id' => 3,
            'author_name'  => 'Ali Hakim',
            'content'      => 'Bagaimana pendapat kalian soal desain UI button berbasis neumorphism?',
            'image'        => null,
        ]);
    }
}
