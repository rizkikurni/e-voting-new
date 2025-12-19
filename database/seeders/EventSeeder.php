<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Faker\Factory;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'customer')->get();

        foreach ($users as $user) {
            $total = rand(1, 3);

            for ($i = 1; $i <= $total; $i++) {
                Event::create([
                    'user_id' => $user->id,
                    'plan_id' => rand(1, 3),
                    // perlu diperbaiki ini
                    'user_plan_id' => rand(1, 3),
                    'title' => "Event {$user->id} - $i",
                    'description' => 'Event voting dummy',
                    'start_time' => now(),
                    'end_time' => now()->addDays(rand(1, 5)),
                    'is_published' => true,
                ]);
            }
        }
    }
}
