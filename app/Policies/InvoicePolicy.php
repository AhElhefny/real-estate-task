<?php

namespace App\Policies;

use App\Enums\InvoiceStatusEnum;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}
    public function create(User $user, Contract $contract): bool
    {
        return $user->id === $contract->tenant_id;
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->id === $invoice->tenant_id;
    }

    public function recordPayment(User $user, Invoice $invoice): bool
    {
        return $user->id === $invoice->tenant_id && $invoice->status !== InvoiceStatusEnum::CANCELLED;
    }
}
