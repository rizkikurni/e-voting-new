<?php

namespace Database\Seeders;

use App\Models\VoterToken;
use App\Models\Event;
use Illuminate\Database\Seeder;

class VoterTokenSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            $total = rand(10, 100);

            for ($i = 0; $i < $total; $i++) {
                VoterToken::create([
                    'event_id' => $event->id,
                    'token' => strtoupper(\Illuminate\Support\Str::random(6)),
                ]);
            }
        }
    }
}
