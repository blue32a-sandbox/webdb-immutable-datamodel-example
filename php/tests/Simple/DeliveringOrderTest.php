<?php

namespace Tests\Simple;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Simple\DeliveringOrder;
use LogicException;
use PHPUnit\Framework\TestCase;

class DeliveringOrderTest extends TestCase
{
    public function testValidation(): void
    {
        $this->expectException(LogicException::class);

        new DeliveringOrder(
            '',
            [],
            new Address('JP', '1234567', 'Tokyo', 'Suginami-ku'),
            new DateTimeImmutable()
        );
    }
}
