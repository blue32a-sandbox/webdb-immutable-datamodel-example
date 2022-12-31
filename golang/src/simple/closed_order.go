package simple

import "example/shared"

type ClosedOrder struct {
	orderId     string
	constraints []shared.OrderConstraint
}

func (co ClosedOrder) OrderId() string {
	return co.orderId
}

func (co ClosedOrder) Constraints() []shared.OrderConstraint {
	return co.constraints
}
