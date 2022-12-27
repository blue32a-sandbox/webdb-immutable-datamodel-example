<?php

namespace ImmutableDatamodel\Complex;

enum OrderStatus {
    /** 商品手配中 */
    case IN_PROGRESS;
    /** 配送処理中 */
    case DELIVERING;
    /** 出荷済み */
    case CLOSED;
}
