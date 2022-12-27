<?php

namespace ImmutableDatamodel\Simple;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Shared\OrderConstraint;
use LogicException;

readonly class DeliveringOrder implements Order, OrderClosable
{
    /**
     * @param string $orderId
     * @param OrderConstraint[] $constraints
     * @param Address $deliveryAddress
     * @param DateTimeImmutable $deliveryDate
     */
    public function __construct(
        private string $orderId,
        private array $constraints,
        private Address $deliveryAddress,
        private DateTimeImmutable $deliveryDate
    ) {
        $this->validate($this->orderId, $this->constraints, $this->deliveryAddress, $this->deliveryDate);
    }

    private function validate(
        string $orderId,
        array $constraints,
        Address $deliveryAddress,
        DateTimeImmutable $deliveryDate
    ): void {
        if ($orderId == '') {
            throw new LogicException('This order id blank not allow');
        }

        if (in_array(OrderConstraint::SHIPPING_JAPAN_ONLY, $this->constraints)) {
            if ($this->deliveryAddress->country != 'JP') {
                throw new LogicException(OrderConstraint::SHIPPING_JAPAN_ONLY->getViolationMessage());
            }
        }

        if (in_array(OrderConstraint::DELIVERY_WEEKDAY, $this->constraints)) {
            if (in_array($this->deliveryDate->format('w'), ['0', '6'])) {
                throw new LogicException(OrderConstraint::DELIVERY_WEEKDAY->getViolationMessage());
            }
        }
    }

    public function orderId(): string
    {
        return $this->orderId;
    }

    public function constraints(): array
    {
        return $this->constraints;
    }

    public function close(): ClosedOrder
    {
        return new ClosedOrder($this->orderId(), $this->constraints());
    }
}
