<?php

namespace Tests\Complex;

use DateTimeImmutable;
use ImmutableDatamodel\Complex\Order;
use ImmutableDatamodel\Complex\OrderStatus;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Shared\OrderConstraint;
use LogicException;
use PHPUnit\Framework\TestCase;

class ComplexTest extends TestCase
{
    public function testDeliverWithNoConstraint(): void
    {
        $sut = new Order('1', []);
        $this->assertSame(OrderStatus::IN_PROGRESS, $sut->getStatus());
        $sut->deliver(
            new Address('JP', '1234567', 'Tokyo', 'Suginami-ku'),
            new DateTimeImmutable()
        );
        $this->assertSame(OrderStatus::DELIVERING, $sut->getStatus());
    }

    public function testDeliverWithJPOnly(): void
    {
        $sut = new Order('1', [OrderConstraint::SHIPPING_JAPAN_ONLY]);
        $this->assertSame(OrderStatus::IN_PROGRESS, $sut->getStatus());
        $this->expectException(LogicException::class);
        $sut->deliver(
            new Address('US', '7654321', 'United States', 'New York City'),
            new DateTimeImmutable()
        );
    }
}
