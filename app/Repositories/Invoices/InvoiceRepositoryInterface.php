<?php

namespace App\Repositories\Invoices;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;

interface InvoiceRepositoryInterface
{
    public function create(array $data): Invoice;

    public function findById(int $id): ?Invoice;

    public function getByContractId(int $contractId): Collection;

    public function update(Invoice $invoice, array $data): bool;
}
