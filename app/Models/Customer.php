<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Fields allowed for mass assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'status'
    ];

    // One customer has many proposals
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    // One customer has many invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // One customer has many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
