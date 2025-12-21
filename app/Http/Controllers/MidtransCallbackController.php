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

        Log::info('Midtrans Callback', $payload);

        // ===============================
        // 1. VALIDASI SIGNATURE KEY
        // ===============================
        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $payload['order_id'] .
                $payload['status_code'] .
                $payload['gross_amount'] .
                $serverKey
        );

        if (($payload['signature_key'] ?? '') !== $signatureKey) {
            Log::warning('Midtrans invalid signature', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // ===============================
        // 2. AMBIL DATA PAYMENT
        // ===============================
        $payment = Payment::where('order_id', $payload['order_id'])->first();

        if (!$payment) {
            Log::error('Payment not found', ['order_id' => $payload['order_id']]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // ===============================
        // 3. UPDATE DATA PAYMENT
        // ===============================
        $payment->update([
            'transaction_id'     => $payload['transaction_id'] ?? null,
            'payment_method'     => $payload['payment_type'] ?? null,
            'transaction_status' => $payload['transaction_status'],
            'fraud_status'       => $payload['fraud_status'] ?? null,
            'transaction_time'   => $payload['transaction_time'] ?? null,
            'payload_response' => $payload,
        ]);

        // ===============================
        // 4. JIKA PEMBAYARAN SUKSES
        // ===============================
        if (in_array($payload['transaction_status'], ['settlement', 'capture'])) {

            $exists = UserPlan::where('payment_id', $payment->id)->exists();

            if (!$exists) {
                UserPlan::create([
                    'user_id'        => $payment->user_id,
                    'plan_id'        => $payment->plan_id,
                    'payment_id'     => $payment->id,
                    'used_event'     => 0,
                    'payment_status' => 'paid',
                    'purchased_at'   => now(),
                ]);
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
