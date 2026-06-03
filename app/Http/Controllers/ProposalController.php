<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve search query for filtering records
        $search = request('search');
        
      
        // Apply a dynamic where-clause to search by proposal title or associated customer name.
        $proposals = Proposal::with('customer')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })->paginate(10)->withQueryString();

        return \Inertia\Inertia::render('Proposals/Index', [
            'proposals' => $proposals,
            'filters' => request()->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return \Inertia\Inertia::render('Proposals/Create', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the form inputs
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        Proposal::create($request->all());

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load('customer');
        return \Inertia\Inertia::render('Proposals/Show', [
            'proposal' => $proposal
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        $customers = Customer::all();
        return \Inertia\Inertia::render('Proposals/Edit', [
            'proposal' => $proposal,
            'customers' => $customers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $proposal->update($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal updated successfully!');
    }

    /**
     * Change proposal status
     * 
     */
    public function changeStatus(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $proposal->update([
            'status' => $validated['status'],
        ]);

        // Auto-create an invoice when proposal is approved
        if ($validated['status'] === 'approved') {
            $invoice = Invoice::create([
                'customer_id' => $proposal->customer_id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'amount' => $proposal->amount,
                'due_date' => now()->addDays(30), // set the due date for 30 days
                'status' => 'unpaid',
            ]);

            // Send the invoice email to the customer
            Mail::to($proposal->customer->email)->send(new InvoiceMail($invoice));
        }

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal deleted successfully!');
    }
}
