<?php

namespace ImmutableDatamodel\Simple\Composability;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Shared\OrderConstraint;
use ImmutableDatamodel\Simple\Deliverable;
use ImmutableDatamodel\Simple\DeliveringOrder;
use ImmutableDatamodel\Simple\Order;

readonly class WinningOrder implements Order, Deliverable
{
    /**
     * @param string $orderId
     * @param OrderConstraint[] $constraints
     * @param string $productSerialNo
     */
    public function __construct(
        private string $orderId,
        private array  $constraints,
        private string $productSerialNo
    ) {
    }

    public function orderId(): string
    {
        return $this->orderId;
    }

    public function constraints(): array
    {
        return $this->constraints;
    }

    public function productSerialNo(): string
    {
        return $this->productSerialNo;
    }

    public function deliver(Address $deliveryAddress, DateTimeImmutable $deliveryDate): DeliveringOrder
    {
        return new DeliveringOrder($this->orderId(), $this->constraints(), $deliveryAddress, $deliveryDate);
    }
}
