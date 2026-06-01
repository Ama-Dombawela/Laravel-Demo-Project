<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model

{
    // Fields allowed for mass assignment
    protected $fillable = [
        'customer_id',
        'invoice_id',
        'stripe_payment_id',
        'amount',
        'status'
    ];

    // Transaction belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Transaction belongs to an invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
