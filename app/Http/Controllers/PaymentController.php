<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

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

        return view('payments.success', compact('payment'));
    }
}
