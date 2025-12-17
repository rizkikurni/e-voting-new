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
        // Pastikan user login
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $orderId = $request->query('order_id');

        if (!$orderId) {
            abort(404, 'Order ID tidak ditemukan');
        }



        // Ambil data payment beserta relasi plan
        $payment = Payment::with('plan')
            ->where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!in_array($payment->transaction_status, ['settlement', 'capture'])) {
            return redirect()
                ->route('payment.pending', ['order_id' => $payment->order_id])
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
