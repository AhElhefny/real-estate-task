<?php

namespace App\Repositories\Invoices;

use App\Models\Invoice;
use App\Repositories\Invoices\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function findById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function getByContractId(int $contractId): Collection
    {
        return Invoice::where('contract_id', $contractId)->get();
    }

    public function update(Invoice $invoice, array $data): bool
    {
        return $invoice->update($data);
    }
}
