<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Retrieve all transactions along with their related customer and invoice data using eager loading
        $transactions = Transaction::with('customers', 'invoices')->get();
        return view('transactions.index', compact('transactions'));
    }

    
}
