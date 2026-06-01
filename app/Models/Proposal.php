<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
   // Fields allowed for mass assignment
    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'amount',
        'status'
    ];

    // Proposal belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
