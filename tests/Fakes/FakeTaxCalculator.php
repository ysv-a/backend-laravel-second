<?php

namespace Tests\Fakes;

use App\Services\ExampleDependency\TaxCalculatorInterface;

class FakeTaxCalculator implements TaxCalculatorInterface
{

    public function calculate(int $price): float
    {
        return 5.55;
    }
}
