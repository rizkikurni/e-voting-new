<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['Basic', 25000, 1, 5, 100],
            ['Standard', 50000, 2, 10, 300],
            ['Premium', 100000, 5, 20, 1000],
        ];

        foreach ($plans as $p) {
            SubscriptionPlan::create([
                'name'          => $p[0],
                'price'         => $p[1],
                'features'      => ['report' => true, 'export' => true],
                'max_event'     => $p[2],
                'max_candidates'=> $p[3],
                'max_voters'    => $p[4],
            ]);
        }

        // Tambah random 12 paket agar total minimal 15
        for ($i = 1; $i <= 12; $i++) {
            SubscriptionPlan::create([
                'name' => "Plan Custom $i",
                'price' => rand(20000,150000),
                'features' => ['custom' => true],
                'max_event' => rand(1, 5),
                'max_candidates' => rand(5, 20),
                'max_voters' => rand(50, 1000),
            ]);
        }
    }
}
