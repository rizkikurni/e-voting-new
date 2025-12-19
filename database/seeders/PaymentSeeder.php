<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Payment;
use App\Models\SubscriptionPlan;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua plan ID
        $planIds = SubscriptionPlan::pluck('id')->toArray();

        if (empty($planIds)) {
            $this->command->warn('❌ Tidak ada subscription plan.');
            return;
        }

        // Ambil user role customer
        $users = User::where('role', 'customer')->get();

        foreach ($users as $index => $user) {

            // Random paid_at (6 bulan terakhir)
            $randomPaidAt = Carbon::createFromTimestamp(
                rand(
                    Carbon::now()->subMonths(6)->timestamp,
                    Carbon::now()->timestamp
                )
            );

            Payment::create([
                'user_id' => $user->id,
                'plan_id' => $planIds[array_rand($planIds)],
                'order_id' => 'ORDER-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'snap_token' => 'snap-' . uniqid(),
                'amount' => rand(50, 300) * 1000,
                'payment_method' => 'bank_transfer',
                'payment_gateway' => 'midtrans',
                'transaction_id' => 'TRX-' . uniqid(),
                'transaction_status' => 'settlement',
                'fraud_status' => 'accept',
                'transaction_time' => $randomPaidAt,
                'paid_at' => $randomPaidAt,
            ]);
        }
    }
}
