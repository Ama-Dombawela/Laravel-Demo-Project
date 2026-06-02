<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

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
        $invoice = Invoice::create([
            'customer_id'    => $request->customer_id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount'         => $request->amount,
            'due_date'       => $request->due_date,
            'status'         => 'sent', // Set default status to 'sent' when creating an invoice
        ]);


    // Automatically send email to customer with Pay Now button
    Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));

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

        $invoice->update($request->only(['customer_id', 'amount', 'due_date']));

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully!');
    }

    /**
     * Change the status of the invoice between paid and unpaid
     */
    public function changeStatus(Invoice $invoice)
    {
        $invoice->update([
            'status' => $invoice->status === 'paid' ? 'unpaid' : 'paid'
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice status updated successfully!');
    }

    /**
     * Sending the Invoice to the customer via email
     */

    public function sendInvoice(Invoice $invoice)
    {

        Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice sending coming soon!');
    }

    /**
     * Create a Stripe checkout session and redirect the Stripe checkout page to pay the invoice amount
     * This is triggered when the customer clicks "Pay Now" in the email
     */
    public function createCheckout(Invoice $invoice)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        //Create a Stripe checkout Session with the invoice detials
        $session = StripeSession::create([
            'payment_method_types' => ['card'], //Card payments only
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => ['name' => 'Invoice #' . $invoice->invoice_number],
                    'unit_amount'  => (int)($invoice->amount * 100),
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment', //One-time-payemnt
            // After successful payment, redirect to success page with session ID and invoice ID 
            'success_url' => route('invoices.payment.success') . '?session_id={CHECKOUT_SESSION_ID}&invoice_id=' . $invoice->id,
            'cancel_url'  => route('invoices.index'),//If cutmer cancels ,redirect back to invoice list
        ]);

        // Redirect the customer to the Stripe hosted payment page
        return redirect($session->url);
    }

    /**
     * Handle the successful payment return from Stripe
     * Automatically updates the invoice status to 'paid'
     */
    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve the Stripe session using the session_id from the URL
        $session = StripeSession::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            
        $invoice =Invoice::find($request->invoice_id);

        $invoice->update(['status' => 'paid']);

        Transaction::create([
            'customer_id' => $invoice->customer_id,
            'invoice_id'  => $invoice->id,
            'amount'      => $invoice->amount,
            'status'      => 'success',
            'stripe_payment_id' => $session->payment_intent,
        ]);
        }

        return view('invoices.payment-success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }
}
