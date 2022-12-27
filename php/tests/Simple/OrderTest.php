<?php

namespace Tests\Simple;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Shared\OrderConstraint;
use ImmutableDatamodel\Simple\InProgressOrder;
use LogicException;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testDeliverWithNoConstraint(): void
    {
        $inProgressOrder = new InProgressOrder('1', []);
        $deliveringOrder = $inProgressOrder->deliver(
            new Address('JP', '1234567', 'Tokyo', 'Suginami-ku'),
            new DateTimeImmutable()
        );

        $this->assertSame('1', $deliveringOrder->orderId());
    }

    public function testDeliverWithJPOnly(): void
    {
        $inProgressOrder = new InProgressOrder('1', [OrderConstraint::SHIPPING_JAPAN_ONLY]);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('This order is shipping only for Japan');

        $inProgressOrder->deliver(
            new Address('US', '7654321', 'United States', 'New York City'),
            new DateTimeImmutable()
        );
    }

    public function testOrderClose(): void
    {
        $inProgressOrder = new InProgressOrder('1', []);
        $deliveringOrder = $inProgressOrder->deliver(
            new Address('JP', '1234567', 'Tokyo', 'Suginami-ku'),
            new DateTimeImmutable()
        );
        $closedOrder = $deliveringOrder->close();

        $this->assertSame('1', $closedOrder->orderId());
    }
}
