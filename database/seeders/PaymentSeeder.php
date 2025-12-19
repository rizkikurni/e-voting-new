<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [1, 2, 3];

        for ($i = 1; $i <= 40; $i++) {
            Payment::create([
                'user_id' => $i + 1,
                'plan_id' => $plans[array_rand($plans)],
                'order_id' => 'ORDER-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'snap_token' => 'snap-' . uniqid(),
                'amount' => rand(50, 300) * 1000,
                'payment_method' => 'bank_transfer',
                'payment_gateway' => 'midtrans',
                'transaction_id' => 'TRX-' . uniqid(),
                'transaction_status' => 'settlement',
                'fraud_status' => 'accept',
                'transaction_time' => now(),
            ]);
        }
    }
}
