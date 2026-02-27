<?php

namespace App\DTOS;

use App\Enums\PaymentMethodEnum;
use App\Http\Requests\RecordPaymentRequest;
use App\Models\Invoice;

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

    public static function fromRequest(RecordPaymentRequest $request, Invoice $invoice): self
    {
        return new self(
            invoice_id: $invoice->id,
            amount: $request->validated()['amount'],
            payment_method: PaymentMethodEnum::from($request->validated()['payment_method']),
            reference_number: $request->validated()['reference_number'],
        );
    }
}
