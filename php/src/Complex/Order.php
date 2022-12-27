<?php

namespace ImmutableDatamodel\Complex;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;
use ImmutableDatamodel\Shared\OrderConstraint;
use LogicException;

class Order
{
    private OrderStatus $status;
    private Address|null $deliveryAddress;
    private DateTimeImmutable|null $deliveryDate;

    /**
     * @param string $orderId
     * @param OrderConstraint[] $constraints
     */
    public function __construct(
        private readonly string $orderId,
        private readonly array $constraints
    ) {
        $this->status = OrderStatus::IN_PROGRESS;
    }

    private function validate(): void
    {
        if (is_null($this->deliveryAddress)) {
            throw new LogicException('This order requires delivery address');
        }

        if (is_null($this->deliveryDate)) {
            throw new LogicException('This order requires delivery date');
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

    public function deliver(Address $deliveryAddress, DateTimeImmutable $deliveryDate): void
    {
        if ($this->status != OrderStatus::IN_PROGRESS) {
            throw new LogicException('Order status is not in progress');
        }

        $this->deliveryAddress = $deliveryAddress;
        $this->deliveryDate = $deliveryDate;
        $this->status = OrderStatus::DELIVERING;

        $this->validate();
    }

    public function close(): void
    {
        if ($this->status != OrderStatus::DELIVERING) {
            throw new LogicException('Order status is not delivering');
        }

        $this->status = OrderStatus::CLOSED;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function getDeliveryAddress(): Address
    {
        return $this->deliveryAddress;
    }

    public function getDeliveryDate(): DateTimeImmutable
    {
        return $this->deliveryDate;
    }
}
