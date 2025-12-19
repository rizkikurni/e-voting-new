<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'order_id',
        'snap_token',
        'amount',
        'payment_method',
        'payment_gateway',
        'transaction_id',
        'transaction_status',
        'fraud_status',
        'transaction_time',
        'payload_response',
        'paid_at',
    ];

    protected $casts = [
        'payload_response' => 'array',
        'transaction_time' => 'datetime',
        'paid_at' => 'datetime',
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

    public function userPlan()
    {
        return $this->hasOne(UserPlan::class);
    }

    public function isPaid()
    {
        return in_array($this->transaction_status, ['settlement', 'capture']);
    }

    public function isPending()
    {
        return $this->transaction_status === 'pending';
    }
}
