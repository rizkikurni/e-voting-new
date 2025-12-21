<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'plan_id',
        'user_plan_id',
        'title',
        'description',
        'is_trial_event',
        'start_time',
        'end_time',
        'is_published',
        'is_locked',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_published' => 'boolean',
        'is_locked' => 'boolean',
        'is_trial_event' => 'boolean',
    ];

    // RELATIONS
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function tokens()
    {
        return $this->hasMany(VoterToken::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function isEditable()
    {
        return !$this->is_locked && !$this->is_published;
    }
    public function usedTokens()
    {
        return $this->hasMany(VoterToken::class)->where('is_used', true);
    }
}
