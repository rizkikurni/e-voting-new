<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // Validasi signature key
        $serverKey = config('services.midtrans.server_key');
        $signatureKey = hash(
            'sha512',
            $payload['order_id'] .
                $payload['status_code'] .
                $payload['gross_amount'] .
                $serverKey
        );

        if ($signatureKey !== $payload['signature_key']) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari payment berdasarkan order_id
        $payment = Payment::where('order_id', $payload['order_id'])->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Update payment
        $payment->update([
            'transaction_id'     => $payload['transaction_id'] ?? null,
            'payment_method'     => $payload['payment_type'] ?? null,
            'transaction_status' => $payload['transaction_status'],
            'fraud_status'       => $payload['fraud_status'] ?? null,
            'transaction_time'   => $payload['transaction_time'] ?? null,
            'payload_response'   => json_encode($payload),
        ]);

        // Jika pembayaran sukses
        if (in_array($payload['transaction_status'], ['settlement', 'capture'])) {

            // Cegah duplikasi paket
            $exists = UserPlan::where('user_id', $payment->user_id)
                ->where('plan_id', $payment->plan_id)
                ->where('payment_status', 'paid')
                ->exists();

            if (!$exists) {
                UserPlan::create([
                    'user_id' => $payment->user_id,
                    'plan_id' => $payment->plan_id,
                    'payment_id' => $payment->id,
                    'used_event' => 0,
                    'payment_status' => 'paid',
                    'purchased_at' => now(),
                ]);
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
