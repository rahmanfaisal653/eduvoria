<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscribe;
use Carbon\Carbon;

class SubscribeSeeder extends Seeder
{
    public function run(): void
    {
        // Data 1
        Subscribe::create([
            'username'   => 'user1',
            'start_date' => Carbon::now(),
            'end_date'   => Carbon::now()->addDays(30),
            'status'     => 'active',
        ]);

        // Data 2
        Subscribe::create([
            'username'   => 'user2',
            'start_date' => Carbon::now(),
            'end_date'   => Carbon::now()->addDays(30),
            'status'     => 'pending',
        ]);

        // Data 3
        Subscribe::create([
            'username'   => 'user3',
            'start_date' => Carbon::now(),
            'end_date'   => Carbon::now()->addDays(30),
            'status'     => 'failed',
        ]);
    }
}
