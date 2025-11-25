<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('report_admin')->insert([
            [
                'type' => 'bug',
                'reported_by' => 'user1@example.com',
                'description' => 'Tombol tidak bisa diklik',
                'priority' => 'low',
                'content_summary' => 'Bug tombol dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'feedback',
                'reported_by' => 'user2@example.com',
                'description' => 'UI bagus tapi perlu perbaikan warna',
                'priority' => 'low',
                'content_summary' => 'Masukan tampilan halaman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'report',
                'reported_by' => 'user4@example.com',
                'description' => 'Akun dicurigai melakukan spam',
                'priority' => 'low',
                'content_summary' => 'Laporan user spam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
