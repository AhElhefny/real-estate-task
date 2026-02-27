<?php

namespace App\DTOS;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Contract;

readonly class CreateInvoiceDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $contract_id,
        public int $tenant_id,
        public string $due_date,
        )
    {
    }

    public static function fromRequest(StoreInvoiceRequest $request, Contract $contract): self
    {
        return new self(
            contract_id: $contract->id,
            tenant_id: $request->validated()['tenant_id'],
            due_date: $request->validated()['due_date'],
        );
    }
}
