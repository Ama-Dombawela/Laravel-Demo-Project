<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Displaying the dasboard with with summary counts 
    public function index()
    {
        $customerCount = \App\Models\Customer::count();
        $proposalCount = \App\Models\Proposal::count();
        $invoiceCount = \App\Models\Invoice::count();
        $transactionCount = \App\Models\Transaction::count();

        return view('dashboard', compact(
            'customerCount',
            'proposalCount',
            'invoiceCount',
            'transactionCount'
        ));
    }
}
