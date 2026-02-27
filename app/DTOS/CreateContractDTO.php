<?php

namespace App\DTOS;

use App\Http\Requests\StoreContractRequest;

readonly class CreateContractDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $tenant_id,
        public float $rent_amount,
        public string $unit_name,
        public string $customer_name,
        public string $start_date,
        public string $end_date,
    ) {}

    public static function fromRequest(StoreContractRequest $request): self
    {
        return new self(
            tenant_id: $request->validated()['tenant_id'],
            rent_amount: $request->validated()['rent_amount'],
            unit_name: $request->validated()['unit_name'],
            customer_name: $request->validated()['customer_name'],
            start_date: $request->validated()['start_date'],
            end_date: $request->validated()['end_date'],
        );
    }
}
