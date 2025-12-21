<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * ADMIN - List semua pembayaran
     */
    public function index(Request $request)
    {
        $payments = Payment::with([
            'user:id,name,email',
            'plan:id,name,price',
        ])
            ->latest('transaction_time')
            ->get()
            ->map(function ($payment) {
                return [
                    'id'                 => $payment->id,
                    'order_id'           => $payment->order_id,
                    'user_name'          => $payment->user?->name,
                    'user_email'         => $payment->user?->email,
                    'plan_name'          => $payment->plan?->name,
                    'amount'             => $payment->amount,
                    'payment_method'     => $payment->payment_method,
                    'bank'               => $this->resolveBank($payment),
                    'transaction_status' => $payment->transaction_status,
                    'paid_at'            => $payment->paid_at,
                ];
            });

        return view('admin.admin.payments.index', compact('payments'));
    }

    /**
     * ADMIN - Detail pembayaran
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'user:id,name,email',
            'plan:id,name,price,features',
            'userPlan',
        ]);

        return view('admin.admin.payments.show', [
            'payment' => $payment,
            'bank'    => $this->resolveBank($payment),
        ]);
    }

    /**
     * Helper: Ambil bank / channel dari payload Midtrans
     */
    private function resolveBank(Payment $payment): string
    {
        $payload = $payment->payload_response ?? [];

        // Bank Transfer (BCA, BNI, Mandiri, dll)
        if (!empty($payload['va_numbers'][0]['bank'])) {
            return strtoupper($payload['va_numbers'][0]['bank']);
        }

        if (!empty($payload['permata_va_number'])) {
            return 'PERMATA';
        }

        // QRIS
        if ($payment->payment_method === 'qris') {
            return strtoupper($payload['qris_acquirer'] ?? 'QRIS');
        }

        // Credit Card
        if ($payment->payment_method === 'credit_card') {
            return 'CREDIT CARD';
        }

        return strtoupper($payload['payment_type'] ?? '-');
    }
}
