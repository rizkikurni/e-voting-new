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
        $faker = Factory::create('id_ID');

        $events = Event::all();

        foreach ($events as $event) {
            $total = rand(2, 5);

            for ($i = 1; $i <= $total; $i++) {
                Candidate::create([
                    'event_id'    => $event->id, // UUID aman
                    'name'        => $faker->name,
                    'description' => $faker->sentence(8),
                ]);
            }
        }
    }
}
