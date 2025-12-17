<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            SubscriptionPlansSeeder::class,
            UserPlansSeeder::class,
            EventsSeeder::class,
            CandidatesSeeder::class,
            VoterTokensSeeder::class,
            VotesSeeder::class,
            PaymentsSeeder::class,
        ]);
    }
}
