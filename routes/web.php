<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Profile(breeze deafult)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Customers
Route::resource('customers', CustomerController::class)->middleware('auth');
Route::patch('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update')->middleware('auth'); // Update customer stats (partial update)
Route::patch('customers/{customer}/status', [CustomerController::class, 'changeStatus'])->name('customers.changeStatus');

// Proposals
Route::resource('proposals', ProposalController::class);
Route::patch('proposals/{proposal}/status', [ProposalController::class, 'changeStatus'])->name('proposals.changeStatus'); // Custom route to change only proposal status (not full update)

// Invoices
Route::get('invoices/payment/sucesss', [InvoiceController::class, 'paymentSuccess'])->name('invoices.payment.success');
Route::resource('invoices', InvoiceController::class);
Route::patch('invoices/{invoice}/status', [InvoiceController::class, 'changeStatus'])->name('invoices.changeStatus');
Route::post('invoices/{invoice}/send', [InvoiceController::class, 'sendInvoice'])->name('invoices.send'); // Send invoice via email
Route::get('invoices/{invoice}/pay', [InvoiceController::class, 'createCheckout'])->name('invoices.pay'); // Pay invoice route

// Transactions
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

require __DIR__ . '/auth.php';
