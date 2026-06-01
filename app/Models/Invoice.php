<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    // Fields allowed for mass assignment
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'amount',
        'status',
        'due_date'
    ];

    // Invoice belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Invoice has many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
