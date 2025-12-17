<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Transaction;


class PaymentController extends Controller
{

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');

        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Ambil status real-time dari Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $statusResponse = Transaction::status($orderId);
        $status = (object) $statusResponse;

        // Update database
        $payment->update([
            'transaction_status' => $status->transaction_status,
            'payment_method'     => $status->payment_type ?? null,
            'paid_at'            => in_array($status->transaction_status, ['settlement', 'capture'])
                ? now() : null,
        ]);

        // Sekarang cek status
        if (!in_array($payment->transaction_status, ['settlement', 'capture'])) {
            return redirect()
                ->route('payment.pending', ['orderId' => $payment->order_id])
                ->with('warning', 'Pembayaran belum selesai');
        }

        return view('payments.success', compact('payment'));
    }



    public function pending($orderId)
    {
        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $statusResponse = Transaction::status($orderId);
        $status = (object) $statusResponse;

        // UPDATE STATUS PAYMENT
        $payment->update([
            'status'         => $status->transaction_status,
            'payment_method' => $status->payment_type ?? null,
            'paid_at'        => \in_array(
                $status->transaction_status,
                ['settlement', 'capture']
            ) ? now() : null,
        ]);

        return view('payments.pending', compact('payment', 'status'));
    }






    public function checkStatus($orderId)
    {
        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'status' => \in_array($payment->transaction_status, ['settlement', 'capture'])
                ? 'paid'
                : 'pending'
        ]);
    }
}
