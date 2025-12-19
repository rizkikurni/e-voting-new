<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            $total = rand(2, 6);

            for ($i = 1; $i <= $total; $i++) {
                Candidate::create([
                    'event_id' => $event->id,
                    'name' => "Calon $i Event {$event->id}",
                    // 'vote_count' => 0,
                ]);
            }
        }
    }
}
