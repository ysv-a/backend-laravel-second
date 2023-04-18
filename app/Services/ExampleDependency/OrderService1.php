<?php

namespace App\Services\ExampleDependency;

class OrderService1
{
    private TaxCalculator $taxCalculator;

    public array $order = [];
    public float $tax = 0.0;

    public function __construct()
    {
        $this->taxCalculator = new TaxCalculator();
    }

    public function create(array $order): void
    {
        $this->order = $order;
        if($order['tax']) {
            $this->tax = $this->taxCalculator->calculate($this->order['sum']);
        }
    }

    public function taxMessage()
    {
        if($this->tax === 0.0) {
            return 'No Tax';
        }

        return "Tax {$this->tax}";
    }
}
