<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user')->latest()->paginate(20);
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $pendingCount = Payment::where('status', 'pending')->count();
        $successfulCount = Payment::where('status', 'paid')->count();

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'pendingCount', 'successfulCount'));
    }

    public function show(Payment $payment)
    {
        $payment->load('user');

        return view('admin.payments.show', compact('payment'));
    }
}
