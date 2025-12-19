<?php

namespace Database\Seeders;

use App\Models\Vote;
use App\Models\Event;
use App\Models\Candidate;
use App\Models\VoterToken;
use Illuminate\Database\Seeder;
use Faker\Factory;

class VoteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $candidates = Candidate::all();
        $tokens = VoterToken::all();
        $events = Event::all();

        foreach (range(1, 15) as $i) {
            Vote::create([
                'event_id' => $events->random()->id,
                'candidate_id' => $candidates->random()->id,
                'token_id' => $tokens->random()->id,
                'voted_at' => $faker->dateTimeBetween('-5 days', 'now'),
            ]);
        }
    }
}
