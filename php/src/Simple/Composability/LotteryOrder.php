<?php

namespace ImmutableDatamodel\Simple\Composability;

use ImmutableDatamodel\Shared\OrderConstraint;
use ImmutableDatamodel\Simple\Order;

readonly class LotteryOrder implements Order, Winnable
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

    public function win(string $productSerialNo): WinningOrder
    {
        return new WinningOrder($this->orderId(), $this->constraints(), $productSerialNo);
    }
}
