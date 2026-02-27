<?php

namespace App\DTOS;

use App\Enums\PaymentMethodEnum;
use App\Http\Requests\RecordPaymentRequest;

readonly class RecordPaymentDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $invoice_id,
        public float $amount,
        public PaymentMethodEnum $payment_method,
        public string $reference_number,
    ) {}

    public static function fromRequest(RecordPaymentRequest $request): self
    {
        return new self(
            invoice_id: $request->validated()['invoice_id'],
            amount: $request->validated()['amount'],
            payment_method: PaymentMethodEnum::from($request->validated()['payment_method']),
            reference_number: $request->validated()['reference_number'],
        );
    }
}
