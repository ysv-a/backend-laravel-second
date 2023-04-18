<?php

namespace Tests\Unit\ExampleDependency;

use App\Services\ExampleDependency\OrderService2;
use App\Services\ExampleDependency\TaxCalculatorInterface;
use Tests\Fakes\FakeTaxCalculator;
use Tests\TestCase;

class OrderService2Test extends TestCase
{
    public function test_order_service_show_tax_fake()
    {
        $order = ['id' => 1, 'type' => 'product', 'sum' => 555, 'tax'=> true];
        $service = new OrderService2(new FakeTaxCalculator());
        $service->create($order);
        $message = $service->taxMessage();

        $this->assertEquals('Tax 5.55', $message);
    }

    public function test_order_service_show_tax_stub()
    {

        $order = ['id' => 1, 'type' => 'product', 'sum' => 555, 'tax'=> true];
        $stub = $this->createStub(TaxCalculatorInterface::class);

        $stub->method('calculate')->willReturn(5.5);

        $service = new OrderService2($stub);
        $service->create($order);
        $message = $service->taxMessage();

        $this->assertEquals('Tax 5.5', $message);
    }

    public function test_order_service_show_tax_mock()
    {

        $order = ['id' => 1, 'type' => 'product', 'sum' => 555, 'tax'=> true];
        $mock = $this->createMock(TaxCalculatorInterface::class);
        $mock->expects($this->once()) // exactly
            ->method('calculate')
            ->willReturn(5.5);

        $service = new OrderService2($mock);
        $service->create($order);
        $message = $service->taxMessage();

        $this->assertEquals('Tax 5.5', $message);
    }
}
