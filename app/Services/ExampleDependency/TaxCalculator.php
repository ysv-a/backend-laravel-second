<?php

namespace App\Services\ExampleDependency;

class TaxCalculator
{
    public function calculate(int $price): float
    {
        return $price * 0.01;
    }
}
