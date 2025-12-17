<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function checkout(SubscriptionPlan $plan)
    {
        $user = Auth::user();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Generate Order ID
        $orderId = 'ORDER-' . time() . '-' . $user->id;

        // Simpan ke payments (PENDING)
        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'order_id' => $orderId,
            'amount' => $plan->price,
            'transaction_status' => 'pending',
        ]);

        // Payload ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $plan->price,
            ],
            'item_details' => [[
                'id' => $plan->id,
                'price' => $plan->price,
                'quantity' => 1,
                'name' => $plan->name,
            ]],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        // Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Simpan token
        $payment->update([
            'snap_token' => $snapToken,
        ]);

        return view('payments.checkout', compact('snapToken', 'plan', 'payment'));

    }
}
