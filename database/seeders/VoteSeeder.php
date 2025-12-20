<?php

namespace Database\Seeders;

use App\Models\Vote;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Faker\Factory;

class VoteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        $events = Event::with(['candidates', 'tokens'])->get();

        foreach ($events as $event) {

            if ($event->candidates->isEmpty() || $event->tokens->isEmpty()) {
                continue;
            }

            $voteCount = rand(5, min(20, $event->tokens->count()));

            foreach ($event->tokens->take($voteCount) as $token) {
                Vote::create([
                    'event_id'     => $event->id, // UUID
                    'candidate_id' => $event->candidates->random()->id,
                    'token_id'     => $token->id,
                    'voted_at'     => $faker->dateTimeBetween(
                        $event->start_time,
                        $event->end_time
                    ),
                ]);

                $token->update(['is_used' => true]);
            }
        }
    }
}
