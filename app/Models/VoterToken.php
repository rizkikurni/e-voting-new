<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoterToken extends Model
{
    protected $fillable = [
        'event_id',
        'token',
        'is_used',
    ];

    protected $casts = [
        'is_used' => 'boolean',
    ];

    // RELATIONS
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function vote()
    {
        return $this->hasOne(Vote::class, 'token_id');
    }
}
