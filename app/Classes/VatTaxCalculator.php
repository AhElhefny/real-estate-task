<?php

namespace App\Classes;

use App\Interfaces\TaxCalculatorInterface;

class VatTaxCalculator implements TaxCalculatorInterface
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
        // For simplicity, let's assume a flat VAT rate of 15%
        return round($amount * 0.15, 2);
    }
}
