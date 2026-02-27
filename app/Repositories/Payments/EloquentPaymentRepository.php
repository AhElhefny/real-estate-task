<?php

namespace App\Repositories\Payments;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class EloquentPaymentRepository implements PaymentRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function getByInvoiceId(int $invoiceId): Collection
    {
        return Payment::where('invoice_id', $invoiceId)->get();
    }
}
