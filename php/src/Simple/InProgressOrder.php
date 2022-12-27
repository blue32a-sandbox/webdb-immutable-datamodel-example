<?php

namespace ImmutableDatamodel\Simple;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Shared\OrderConstraint;

readonly class InProgressOrder implements Order, Deliverable
{
    /**
     * @param string $orderId
     * @param OrderConstraint[] $constraints
     */
    public function __construct(
        private string $orderId,
        private array  $constraints
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

    public function deliver(Address $deliveryAddress, DateTimeImmutable $deliveryDate): DeliveringOrder
    {
        return new DeliveringOrder($this->orderId(), $this->constraints(), $deliveryAddress, $deliveryDate);
    }
}
