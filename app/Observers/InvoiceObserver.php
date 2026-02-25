<?php

namespace App\Observers;

use App\Models\Invoice;

use function Symfony\Component\Clock\now;

class InvoiceObserver
{
    public function creating($invoice)
    {
        $last_id = Invoice::whereTenantId($invoice->tenant_id)->max('id') ?? 0;
        $tenant_id = str_pad((string)$invoice->tenant_id, 3, '0', STR_PAD_LEFT);
        $new_tenant_invoice_id = str_pad((string)($last_id + 1), 4, '0', STR_PAD_LEFT);
        $invoice->invoice_number = 'INV-' . $tenant_id . '-' . now()->format('Ym') . '-' . $new_tenant_invoice_id;
    }
}
