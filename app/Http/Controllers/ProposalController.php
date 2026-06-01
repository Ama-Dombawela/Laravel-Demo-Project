<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Show all the proposals
        $proposals = Proposal::with('customer')->get();
        return view('proposals.index', compact('proposals'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('proposals.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the form inputs
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'amount'      => 'required|numeric',
        ]);

        Proposal::create($request->all());

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        $customers = Customer::all();
        return view('proposals.edit', compact('proposal', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposals)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'amount'      => 'required|numeric',
        ]);

        $proposals->update($request->all());

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal updated successfully!');
    }

    /**
     * Change proposal status
     * 
     */
    public function changeStatus(Request $request, Proposal $proposal)
    {
        $proposal->update([
            'status' => $request->status,
        ]);

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
