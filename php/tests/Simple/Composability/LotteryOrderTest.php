<?php

namespace Tests\Simple\Composability;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Simple\Composability\LotteryOrder;
use PHPUnit\Framework\TestCase;

class LotteryOrderTest extends TestCase
{
    public function testOrderDeliver(): void
    {
        $lotteryOrder = new LotteryOrder('1', []);
        $winningOrder = $lotteryOrder->win('1234');
        $deliveringOrder = $winningOrder->deliver(
            new Address('JP', '1234567', 'Tokyo', 'Suginami-ku'),
            new DateTimeImmutable()
        );

        $this->assertSame('1', $deliveringOrder->orderId());
    }
}
