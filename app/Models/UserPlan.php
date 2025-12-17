<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'used_event',
        'purchased_at',
        'payment_status',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
    ];

    // RELATIONS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'plan_id', 'plan_id')
                    ->where('user_id', $this->user_id);
    }

    // HELPER: cek quota
    public function hasAvailableEvent()
    {
        return $this->payment_status === 'paid'
            && $this->used_event < $this->plan->max_event;
    }
}
