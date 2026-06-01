<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\InvoiceMail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Retrieve all the invoices along with their customer data using eager loading
        $invoices = Invoice::with('customer')->get();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('invoices.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the form inputs
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount'      => 'required|numeric',
            'due_date'    => 'required|date',
        ]);

        // Auto generate invoice number
        Invoice::create([
            'customer_id'    => $request->customer_id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount'         => $request->amount,
            'due_date'       => $request->due_date,
            'status'         => 'unpaid',
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        return view('invoices.edit', compact('invoice', 'customers'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount'      => 'required|numeric',
            'due_date'    => 'required|date',
        ]);

        $invoice->update([ 'status' => $invoice->status === 'paid' ? 'unpaid' : 'paid' ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully!');
    }

    /**
     * Sending the Invoice to the customer via email
     */

    public function sendInvoice(Invoice $invoices)
    {

        // $customer = $invoice->customer;
        // Mail::to($customer->email)->send(new InvoiceMail($invoice));

        // return redirect()->route('invoices.index')
        //     ->with('success', 'Invoice sent successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoices)
    {
        $invoices->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }
}
