<?php

namespace App\Services\ExampleDependency;

class OrderService2
{

    public array $order = [];
    public float $tax = 0.0;

    public function __construct(
        public readonly TaxCalculatorInterface $taxCalculatorInterface
    ) {
    }

    public function create(array $order): void
    {
        $this->order = $order;
        if($order['tax']) {
            $this->tax = $this->taxCalculatorInterface->calculate($this->order['sum']);
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
