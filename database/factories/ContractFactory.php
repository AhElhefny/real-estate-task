<?php

namespace Database\Factories;

use App\Enums\ContractStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('-6 months', 'now +6 months')->format('Y-m-d');
        $end_date = fake()->dateTimeBetween($start_date, $start_date . ' +1 year')->format('Y-m-d');
        return [
            'tenant_id' => User::inRandomOrder()->first()->id,
            'unit_name' => fake()->word(),
            'customer_name' => fake()->name(),
            'rent_amount' => fake()->randomFloat(2, 500, 5000),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => collect([$this->getSuitableStatus($start_date, $end_date), ContractStatusEnum::TERMINATED])->random(),
        ];
    }

    protected function getSuitableStatus($start_date, $end_date): object
    {
        $now = now()->format('Y-m-d');

        return match (true) {
            $now < $start_date => ContractStatusEnum::DRAFT,
            $now >= $start_date && $now <= $end_date => ContractStatusEnum::ACTIVE,
            default => ContractStatusEnum::EXPIRED,
        };
    }
}
