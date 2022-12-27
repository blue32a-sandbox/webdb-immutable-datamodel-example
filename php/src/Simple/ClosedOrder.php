<?php

namespace ImmutableDatamodel\Simple;

use ImmutableDatamodel\Shared\OrderConstraint;

readonly class ClosedOrder implements Order
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
}
