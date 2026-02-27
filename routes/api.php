<?php

use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('contracts/{contract}/invoices', [InvoiceController::class, 'store']);     // Create invoice for a contract
Route::get('contracts/{contract}/invoices', [InvoiceController::class, 'index']);      // List invoices for a contract (with filters)
Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);                 // Get invoice details with payments
Route::post('invoices/{invoice}/payments', [InvoiceController::class, 'recordPayment']); // Record a payment
Route::get('contracts/{contract}/summary', [InvoiceController::class, 'summary']);     // Financial summary for a contract
