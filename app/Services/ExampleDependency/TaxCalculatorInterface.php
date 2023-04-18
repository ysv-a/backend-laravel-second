<?php

namespace App\Services\ExampleDependency;

interface TaxCalculatorInterface
{
    public function calculate(int $price): float;

}
