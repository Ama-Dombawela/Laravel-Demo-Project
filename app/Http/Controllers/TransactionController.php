<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve search query for filtering records
        $search = request('search');
        

        // Search transactions by payment ID, customer name, or invoice number.
        $transactions = Transaction::with(['customer', 'invoice'])
            ->when($search, function ($query, $search) {
                $query->where('stripe_payment_id', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('invoice', function($q) use ($search) {
                          $q->where('invoice_number', 'like', "%{$search}%");
                      });
            })->paginate(10)->withQueryString();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
            'filters' => request()->only(['search'])
        ]);
    }


}
