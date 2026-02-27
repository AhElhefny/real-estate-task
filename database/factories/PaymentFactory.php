<?php

namespace Database\Factories;

use App\Enums\PaymentMethodEnum;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $invoice = Invoice::inRandomOrder()->first();

        return [
            'tenant_id' => $invoice?->tenant_id,
            'invoice_id' => $invoice?->id,
            'amount' => fake()->randomFloat(2, 10, 500),
            'payment_method' => fake()->randomElement([
                PaymentMethodEnum::CASH->value,
                PaymentMethodEnum::BANK_TRANSFER->value,
                PaymentMethodEnum::CREDIT_CARD->value,
            ]),
            'reference_number' => strtoupper(fake()->bothify('REF-########')),
            'paid_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
