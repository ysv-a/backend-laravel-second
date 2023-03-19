<?php

namespace App\ValueObjects;

class PriceReverse
{
    public readonly int $cent;
    public readonly float $dollar;


    public function __construct(float $dollar)
    {
        if ($dollar < 0) {
            throw new \InvalidArgumentException('Price value cannot be negative');
        }

        $this->dollar = $dollar;

        $this->cent = $dollar * 100;

    }

}
