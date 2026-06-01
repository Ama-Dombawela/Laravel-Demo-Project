<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Show all Customers
        $customers = Customer::all();
        return view('customers.index', compact('customers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the form inputs
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Create the customer
        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customers)
    {
        return view('customers.edit',compact('customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customers)
    {
         $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $customers->id,
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customers->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Updating the status of the customer
     */
    public function updateStatus(Customer $customers)
    {
        $customers->update([
            'status' => $customers->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Status updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customers)
    {
        $customers->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
