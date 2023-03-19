<?php

namespace App\ValueObjects;

class Price
{
    public readonly int $cent;
    public readonly float $dollar;
    public readonly string $formatted;

    public function __construct(int $cent)
    {
        if ($cent < 0) {
            throw new \InvalidArgumentException('Price value cannot be negative');
        }

        $this->cent = $cent;

        $this->dollar = $cent / 100;

        $this->formatted = '$' . number_format($this->dollar, 2);
    }

}
