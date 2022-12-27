<?php

namespace ImmutableDatamodel\Simple;

use DateTimeImmutable;
use ImmutableDatamodel\Shared\Address;

interface Deliverable
{
    public function deliver(Address $deliveryAddress, DateTimeImmutable $deliveryDate): DeliveringOrder;
}
