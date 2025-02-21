<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\invoiceController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
