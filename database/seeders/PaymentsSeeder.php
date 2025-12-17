<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $plans = SubscriptionPlan::all();

        foreach (range(1, 15) as $i) {
            Payment::create([
                'user_id' => $users->random()->id,
                'plan_id' => $plans->random()->id,
                'amount' => rand(25000, 150000),
                'method' => 'transfer',
                'payment_gateway' => 'manual',
                'order_id' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'paid',
            ]);
        }
    }
}
