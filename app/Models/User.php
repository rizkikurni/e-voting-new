<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_trial_used',
        'photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELATIONS
    public function plans()
    {
        return $this->hasMany(UserPlan::class);
    }

    public function activePlans()
    {
        return $this->plans()->where('payment_status', 'paid');
    }

    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }



    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // HELPER: cek apakah user masih punya jatah membuat event
    // public function hasEventQuota()
    // {
    //     return $this->plans()
    //         ->where('payment_status', 'paid')
    //         ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.plan_id')
    //         ->whereColumn('user_plans.used_event', '<', 'subscription_plans.max_event')
    //         ->exists();
    // }
    public function hasEventQuota(): bool
    {
        return $this->plans
            ->where('payment_status', 'paid')
            ->contains(fn($plan) => $plan->hasAvailableEvent());
    }

    // Ambil 1 paket yang masih punya jatah
    public function getAvailablePlan()
    {
        return $this->plans()
            ->where('payment_status', 'paid')
            ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.plan_id')
            ->whereColumn('user_plans.used_event', '<', 'subscription_plans.max_event')
            ->select('user_plans.*')
            ->first();
    }
}
