<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Snap;

class PaymentController extends Controller
{
    private function configureMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');

        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->configureMidtrans();
        $statusResponse = Transaction::status($orderId);
        $status = (object) $statusResponse;

        // Update database
        $payment->update([
            'transaction_status' => $status->transaction_status,
            'payment_method'     => $status->payment_type ?? null,
            'paid_at'            => in_array($status->transaction_status, ['settlement', 'capture'])
                ? now() : null,
        ]);

        // Cek status
        if (!$payment->isPaid()) {
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

        $this->configureMidtrans();
        $statusResponse = Transaction::status($orderId);
        $status = (object) $statusResponse;

        // UPDATE STATUS PAYMENT - FIX: ganti 'status' jadi 'transaction_status'
        $payment->update([
            'transaction_status' => $status->transaction_status,
            'payment_method'     => $status->payment_type ?? null,
            'paid_at'            => in_array($status->transaction_status, ['settlement', 'capture'])
                ? now() : null,
        ]);

        // Jika sudah dibayar, redirect ke success
        if ($payment->isPaid()) {
            return redirect()
                ->route('payment.success', ['order_id' => $payment->order_id])
                ->with('success', 'Pembayaran berhasil!');
        }

        return view('payments.pending', compact('payment', 'status'));
    }

    // TAMBAHKAN METHOD INI untuk tombol "Bayar Sekarang"
    public function pay($orderId)
    {
        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek apakah sudah dibayar
        if ($payment->isPaid()) {
            return redirect()
                ->route('payment.success', ['order_id' => $payment->order_id])
                ->with('info', 'Pembayaran sudah lunas');
        }

        // Cek apakah sudah expire
        if ($payment->transaction_status === 'expire') {
            return redirect()
                ->route('payments.index')
                ->with('error', 'Transaksi sudah kadaluarsa. Silakan buat pesanan baru.');
        }

        // Redirect ke halaman pending dengan snap token
        return view('payments.pay', compact('payment'));
    }

    public function checkStatus($orderId)
    {
        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'status' => $payment->isPaid() ? 'paid' : 'pending',
            'transaction_status' => $payment->transaction_status
        ]);
    }

    public function index()
    {
        $payments = Payment::with('plan')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('admin.payments.index', compact('payments'));
    }
}
