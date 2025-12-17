<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Faker\Factory;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $users = User::all();
        $plans = SubscriptionPlan::all();

        foreach (range(1, 15) as $i) {
            $start = $faker->dateTimeBetween('-10 days', '+10 days');
            $end = (clone $start)->modify('+2 hours');

            Event::create([
                'user_id' => $users->random()->id,
                'plan_id' => $plans->random()->id,
                'title' => "Event Voting $i",
                'description' => $faker->sentence(),
                'is_trial_event' => false,
                'start_time' => $start,
                'end_time' => $end,
                'is_published' => rand(0, 1),
                'is_locked' => rand(0, 1),
            ]);
        }
    }
}
