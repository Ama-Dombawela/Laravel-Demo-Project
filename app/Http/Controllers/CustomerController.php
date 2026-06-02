<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Show all Customers
        $customers = Customer::all();
        return Inertia::render('Customers/Index', [
            'customers' => $customers
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Customers/Create');
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
        Customer::create($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Customers/Edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
         $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $customer->id,
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Updating the status of the customer
     */
    public function changeStatus(Customer $customer)
    {
        $customer->update([
            'status' => $customer->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Status updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
