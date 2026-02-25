<?php

namespace Database\Factories;

use App\Enums\ContractStatusEnum;
use App\Enums\InvoiceStatusEnum;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $due_date = fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d');
        $status = $this->getSuitableStatus($due_date);
        $contract = Contract::with('tenant')->whereStatus(ContractStatusEnum::ACTIVE->value)->inRandomOrder()->first();
        $sub_total = fake()->randomFloat(2, 100, 1000);
        $tax_amount = fake()->randomFloat(2, 10, 100);
        return [
            'contract_id' => $contract->id,
            'tenant_id' => $contract->tenant_id,
            'subtotal' => $sub_total,
            'tax_amount' => $tax_amount,
            'total' => $sub_total + $tax_amount,
            'status' => $status,
            'due_date' => $due_date,
            'paid_at' => $status === InvoiceStatusEnum::PAID ? Carbon::parse($due_date)->subDays(rand(1,5)) : null,
        ];
    }

    private function getSuitableStatus($due_date): object
    {
        $now = now()->format('Y-m-d');
        return match (true) {
            $due_date <= $now => collect([InvoiceStatusEnum::OVERDUE, InvoiceStatusEnum::PAID, InvoiceStatusEnum::CANCELLED])->random(),
            $due_date > $now => collect([InvoiceStatusEnum::PENDING, InvoiceStatusEnum::PAID, InvoiceStatusEnum::PARTIALLY_PAID])->random(),
            default => InvoiceStatusEnum::PENDING,
        };
    }
}
