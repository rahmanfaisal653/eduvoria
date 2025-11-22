<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Community;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        
        $ownerId = 1;

        
        Community::create([
            'name'            => 'Fotografer Alam',
            'slug'            => Str::slug('Fotografer Alam'),
            'description'     => 'Komunitas bagi pecinta fotografi alam dan landscape.',
            'category'        => 'Fotografi',
            'owner_id'        => $ownerId,
            'members_count'   => 2100,
            'profile_image'   => 'fotografer_alam_profile.jpg',   
            'background_image'=> 'fotografer_alam_bg.jpg',
        ]);

       
        Community::create([
            'name'            => 'Pecinta Tanaman',
            'slug'            => Str::slug('Pecinta Tanaman'),
            'description'     => 'Tempat berbagi tips merawat tanaman hias dan urban farming.',
            'category'        => 'Hobi',
            'owner_id'        => $ownerId,
            'members_count'   => 800,
            'profile_image'   => 'pecinta_tanaman_profile.jpg',
            'background_image'=> 'pecinta_tanaman_bg.jpg',
        ]);

        Community::create([
            'name'            => 'UI/UX Designer',
            'slug'            => Str::slug('UI/UX Designer'),
            'description'     => 'Diskusi seputar desain antarmuka dan pengalaman pengguna.',
            'category'        => 'TechDesign',
            'owner_id'        => $ownerId,
            'members_count'   => 4500,
            'profile_image'   => 'uiux_profile.jpg',
            'background_image'=> 'uiux_bg.jpg',
        ]);
    }
}
