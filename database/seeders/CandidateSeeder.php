<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CandidatesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $events = Event::all();

        foreach (range(1, 15) as $i) {
            Candidate::create([
                'event_id' => $events->random()->id,
                'name' => $faker->name(),
                'description' => $faker->sentence(),
                'photo' => null,
            ]);
        }
    }
}
