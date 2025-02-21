<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\invoiceController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');

Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');


Route::get('/invoice/{invoice_number}', [InvoiceController::class, 'show'])->name('invoice.show');

Route::get('/invoice/{invoice_number}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');