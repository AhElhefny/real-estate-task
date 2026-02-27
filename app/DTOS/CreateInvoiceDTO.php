<?php

namespace App\DTOS;

use App\Http\Requests\StoreInvoiceRequest;

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

    public static function fromRequest(StoreInvoiceRequest $request): self
    {
        return new self(
            contract_id: $request->validated()['contract_id'],
            tenant_id: $request->validated()['tenant_id'],
            due_date: $request->validated()['due_date'],
        );
    }
}
