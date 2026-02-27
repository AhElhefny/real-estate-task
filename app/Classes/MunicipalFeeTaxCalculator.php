<?php

namespace App\Classes;

use App\Interfaces\TaxCalculatorInterface;

class MunicipalFeeTaxCalculator implements TaxCalculatorInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function calculate(float $amount): float
    {
        // For simplicity, let's assume a flat municipal fee of 2.5%
        return round($amount * 0.025, 2);
    }
}
