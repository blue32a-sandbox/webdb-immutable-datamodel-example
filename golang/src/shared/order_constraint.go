package shared

type OrderConstraint int

const (
	SHIPPING_JAPAN_ONLY OrderConstraint = iota
	DELIVERY_WEEKDAY
)

var messages = map[OrderConstraint]string{
	SHIPPING_JAPAN_ONLY: "this order is shipping only for Japan",
	DELIVERY_WEEKDAY:    "this order can deliver only on weekday",
}

func (oc OrderConstraint) ViolationMessage() string {
	return messages[oc]
}
