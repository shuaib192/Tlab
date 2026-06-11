<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('user')->latest()->paginate(20);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['parent', 'entrepreneur', 'aider'])->orderBy('name')->get();

        return view('admin.invoices.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'due_date' => 'nullable|date|after:today',
            'items' => 'nullable|json',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['invoice_number'] = Invoice::generateNumber();
        $validated['amount'] = (int) (floatval($validated['amount']) * 100);
        $validated['items'] = $validated['items'] ? json_decode($validated['items'], true) : null;

        Invoice::create($validated);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('user');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.invoices.pdf', compact('invoice'));

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
