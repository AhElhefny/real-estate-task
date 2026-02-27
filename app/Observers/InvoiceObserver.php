<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{
    public function creating(Invoice $invoice): void
    {
        $lastId = Invoice::where('tenant_id', $invoice->tenant_id)->max('id') ?? 0;

        $tenant = str_pad((string) $invoice->tenant_id, 3, '0', STR_PAD_LEFT);
        $seq    = str_pad((string) ($lastId + 1), 4, '0', STR_PAD_LEFT);

        $invoice->invoice_number = 'INV-' . $tenant . '-' . now()->format('Ym') . '-' . $seq;
    }
}
