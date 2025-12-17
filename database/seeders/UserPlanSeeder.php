<?php

namespace Database\Seeders;

use App\Models\UserPlan;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class UserPlansSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $plans = SubscriptionPlan::all();

        foreach (range(1, 15) as $i) {
            UserPlan::create([
                'user_id' => $users->random()->id,
                'plan_id' => $plans->random()->id,
                'used_event' => rand(0, 1),
                'purchased_at' => now()->subDays(rand(1, 30)),
                'payment_status' => 'paid',
            ]);
        }
    }
}
