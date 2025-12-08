<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;
use App\Models\Bookmark;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Eduvoria',
            'email' => 'admin2@eduvoria.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'bio' => 'Administrator platform Eduvoria',
            'hobi' => 'Mengelola komunitas belajar',
            'followers_count' => 1000,
            'following_count' => 50
        ]);

        // Create Test Users
        $user1 = User::create([
            'name' => 'Faisal Rahman',
            'email' => 'faisal@eduvoria.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'bio' => 'God is good. Suka belajar hal baru.',
            'hobi' => 'Fotografi, Sepak Bola, Catur',
            'followers_count' => 400,
            'following_count' => 593
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@eduvoria.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'bio' => 'Passionate learner | Tech enthusiast',
            'hobi' => 'Coding, Reading, Music',
            'followers_count' => 250,
            'following_count' => 180
        ]);

        $user3 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@eduvoria.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'bio' => 'Learning something new every day',
            'hobi' => 'Gaming, Cooking, Traveling',
            'followers_count' => 150,
            'following_count' => 220
        ]);

        // Create Sample Posts
        $post1 = Post::create([
            'user_id' => $user1->id,
            'content' => 'Jangan lupa kerjain PR guys! Deadline besok ya.',
            'likes_count' => 15
        ]);

        $post2 = Post::create([
            'user_id' => $user1->id,
            'content' => 'Mama said I\'m the best :)',
            'likes_count' => 50
        ]);

        $post3 = Post::create([
            'user_id' => $user2->id,
            'content' => 'Baru saja selesai belajar Laravel. Framework yang sangat powerful!',
            'likes_count' => 32
        ]);

        $post4 = Post::create([
            'user_id' => $user3->id,
            'content' => 'Tips produktif: Buat to-do list setiap pagi!',
            'likes_count' => 24
        ]);

        $post5 = Post::create([
            'user_id' => $admin->id,
            'content' => 'Selamat datang di Eduvoria! Mari belajar bersama.',
            'likes_count' => 100
        ]);

        // Create Sample Bookmarks
        Bookmark::create([
            'user_id' => $user1->id,
            'post_id' => $post3->id  
        ]);

        Bookmark::create([
            'user_id' => $user1->id,
            'post_id' => $post5->id  
        ]);

        Bookmark::create([
            'user_id' => $user2->id,
            'post_id' => $post1->id  
        ]);

        Bookmark::create([
            'user_id' => $user3->id,
            'post_id' => $post2->id  
        ]);

        Bookmark::create([
            'user_id' => $user3->id,
            'post_id' => $post3->id
        ]);

        $this->call(ReportAdminSeeder::class);
        $this->call(SubscribeSeeder::class);

        echo "\n✅ Seeding completed successfully!\n";
        echo "📧 Admin: admin@eduvoria.com | Password: admin123\n";
        echo "📧 User 1: faisal@eduvoria.com | Password: password123\n";
        echo "📧 User 2: siti@eduvoria.com | Password: password123\n";
        echo "📧 User 3: budi@eduvoria.com | Password: password123\n";
        echo "📚 5 Posts and 5 Bookmarks created\n\n";
        
        $this->call([
            CommunitySeeder::class,
            CommunityPostSeeder::class,
        ]);
    }
}
