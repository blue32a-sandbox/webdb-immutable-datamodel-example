<?php

namespace ImmutableDatamodel\Shared;

readonly class Address
{
    public function __construct(
        public readonly string $country,
        public readonly string $postalCode,
        public readonly string $region,
        public readonly string $streetAddress
    ) {
    }
}
