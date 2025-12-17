<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'event_id',
        'candidate_id',
        'token_id',
        'voted_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    // RELATIONS
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function token()
    {
        return $this->belongsTo(VoterToken::class);
    }
}
