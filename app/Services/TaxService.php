<?php

namespace App\Services;



class TaxService
{
    public function __construct(private array $calculators) {}

    public function calculateTax(float $amount): float
    {
        $total = 0;
        foreach ($this->calculators as $calculator) {
            $total += $calculator->calculate($amount);
        }

        return round($total, 2);
    }
}
