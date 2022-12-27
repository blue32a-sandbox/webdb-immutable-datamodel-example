<?php

namespace ImmutableDatamodel\Simple\Composability;

interface Winnable
{
    public function win(string $productSerialNo): WinningOrder;
}
