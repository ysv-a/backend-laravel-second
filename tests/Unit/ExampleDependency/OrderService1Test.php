<?php

namespace Tests\Unit\ExampleDependency;

use App\Services\ExampleDependency\OrderService1;
use Tests\TestCase;

class OrderService1Test extends TestCase
{
    public function test_show_tax()
    {
        $order = ['id' => 1, 'type' => 'product', 'sum' => 555, 'tax'=> true];

        $service = new OrderService1();
        $service->create($order);
        $message = $service->taxMessage();

        $this->assertEquals('Tax 5.55', $message);
    }

    public function test_show_tax_if_tax_false()
    {
        $order = ['id' => 1, 'type' => 'product', 'sum' => 555, 'tax'=> false];

        $service = new OrderService1();
        $service->create($order);
        $message = $service->taxMessage();

        $this->assertEquals('No Tax', $message);
    }

}
