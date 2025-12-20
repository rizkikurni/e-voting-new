<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Database\Seeder;
use Faker\Factory;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $customers = User::where('role', 'customer')->get();

        foreach ($customers as $user) {

            $userPlans = UserPlan::where('user_id', $user->id)->get();
            if ($userPlans->isEmpty()) {
                continue;
            }

            $totalEvent = rand(1, 3);

            for ($i = 0; $i < $totalEvent; $i++) {

                $start = now()->subDays(rand(1, 5));
                $end   = (clone $start)->addDays(rand(1, 5));

                Event::create([
                    'user_id'       => $user->id,
                    'plan_id'       => $userPlans->random()->plan_id,
                    'user_plan_id'  => $userPlans->random()->id,
                    'title'         => 'Pemilihan ' . $faker->jobTitle,
                    'description'   => $faker->sentence(12),
                    'start_time'    => $start,
                    'end_time'      => $end,
                    'is_published'  => true,
                    'is_locked'     => false,
                ]);
            }
        }
    }
}
