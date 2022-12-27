<?php

namespace ImmutableDatamodel\Simple;

interface OrderClosable
{
    public function close(): ClosedOrder;
}
