<?php

namespace App\ValueObjects;

class Price
{
    public readonly int $cent;
    public readonly float $dollar;
    public readonly string $formatted;

    private function __construct(int $cent = 0, float $dollar = 0)
    {
        if ($dollar) {
            $this->dollar = $dollar;

            $this->cent = $dollar * 100;
        }

        if ($cent) {
            $this->cent = $cent;

            $this->dollar = $cent / 100;
        }

        $this->formatted = '$' . number_format($this->dollar, 2);
    }

    public static function fromMinimum(int $cent)
    {
        if ($cent < 0) {
            throw new \InvalidArgumentException('Price value cannot be negative');
        }

        return new self($cent);
    }

    public static function fromMaximum(float $dollar)
    {
        if ($dollar < 0) {
            throw new \InvalidArgumentException('Price value cannot be negative');
        }

        return new self(0, $dollar);
    }
}
