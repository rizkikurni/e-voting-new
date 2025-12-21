<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'features',
        'max_event',
        'max_candidates',
        'max_voters',
        'is_recommended',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    // RELATIONS
    public function userPlans()
    {
        return $this->hasMany(UserPlan::class, 'plan_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'plan_id');
    }
}
