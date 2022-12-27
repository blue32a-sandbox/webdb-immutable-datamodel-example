<?php

namespace ImmutableDatamodel\Shared;

enum OrderConstraint
{
    case SHIPPING_JAPAN_ONLY;
    case DELIVERY_WEEKDAY;

    public function getViolationMessage(): string
    {
        return match($this) {
            OrderConstraint::SHIPPING_JAPAN_ONLY => 'This order is shipping only for Japan',
            OrderConstraint::DELIVERY_WEEKDAY => 'This order can deliver only on weekday',
        };
    }
}
