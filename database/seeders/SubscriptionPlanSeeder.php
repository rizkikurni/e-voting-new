<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Basic',
            'price' => 100000,
            'features' => ['report' => false, 'export' => false, 'custom' => false],
            'max_event' => 1,
            'max_candidates' => 10,
            'max_voters' => 100,
            'is_recommended' => 'no',
        ]);

        SubscriptionPlan::create([
            'name' => 'Standard',
            'price' => 200000,
            'features' => ['report' => true, 'export' => false, 'custom' => false],
            'max_event' => 5,
            'max_candidates' => 50,
            'max_voters' => 1000,
            'is_recommended' => 'yes',
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium',
            'price' => 250000,
            'features' => ['report' => true, 'export' => true, 'custom' => true],
            'max_event' => 999,
            'max_candidates' => 999,
            'max_voters' => 999999,
            'is_recommended' => 'no',
        ]);

        $this->command->info('Subscription plans seeded successfully!');
    }
}
