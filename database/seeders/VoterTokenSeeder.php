<?php

namespace Database\Seeders;

use App\Models\VoterToken;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VoterTokenSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            $total = rand(20, 100);

            for ($i = 0; $i < $total; $i++) {

                do {
                    $token = strtoupper(Str::random(6));
                } while (VoterToken::where('token', $token)->exists());

                VoterToken::create([
                    'event_id' => $event->id, // UUID
                    'token'    => $token,
                ]);
            }
        }
    }
}
