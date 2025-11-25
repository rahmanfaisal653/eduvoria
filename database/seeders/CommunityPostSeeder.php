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
            'user_id'      => 1,
            'content'      => 'Halo! Ini postingan pertama di komunitas Fotografer Alam.',
            'image'        => null,
        ]);

        CommunityPost::create([
            'community_id' => 1,
            'user_id'      => 2,
            'content'      => 'Berbagi foto lanskap terbaru saya! Bagaimana menurut kalian?',
            'image'        => 'lanskap1.jpg',
        ]);

       
        CommunityPost::create([
            'community_id' => 2,
            'user_id'      => 3,
            'content'      => 'Tanaman monstera saya tumbuh subur! Ada yang mau tips rawatan?',
            'image'        => null,
        ]);

        
        CommunityPost::create([
            'community_id' => 3,
            'user_id'      => 4,
            'content'      => 'Bagaimana pendapat kalian soal desain UI button berbasis neumorphism?',
            'image'        => null,
        ]);
    }
}
