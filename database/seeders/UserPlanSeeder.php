<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\UserPlan;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class UserPlanSeeder extends Seeder
{
    public function run(): void
    {
        $payments = Payment::all();

        foreach ($payments as $payment) {
            UserPlan::create([
                'user_id' => $payment->user_id,
                'payment_id' => $payment->id,
                'plan_id' => $payment->plan_id,
                'used_event' => rand(0, 3),
                'purchased_at' => now()->subDays(rand(1, 30)),
                'payment_status' => 'paid',
            ]);
        }
    }
}
