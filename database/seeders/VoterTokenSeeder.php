<?php

namespace Database\Seeders;

use App\Models\VoterToken;
use App\Models\Event;
use Illuminate\Database\Seeder;

class VoterTokensSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();

        foreach (range(1, 15) as $i) {
            VoterToken::create([
                'event_id' => $events->random()->id,
                'token' => strtoupper(substr(md5(uniqid()), 0, 6)),
                'is_used' => rand(0, 1),
            ]);
        }
    }
}
