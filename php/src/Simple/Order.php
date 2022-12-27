<?php

namespace ImmutableDatamodel\Simple;

use ImmutableDatamodel\Shared\OrderConstraint;

interface Order {
    public function orderId(): string;

    /** @return OrderConstraint[] */
    public function constraints(): array;
}
