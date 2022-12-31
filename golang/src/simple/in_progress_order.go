package simple

import (
	"example/shared"
	"time"
)

type InProgressOrder struct {
	orderId     string
	constraints []shared.OrderConstraint
}

func (ipo InProgressOrder) OrderId() string {
	return ipo.orderId
}

func (ipo InProgressOrder) Constraints() []shared.OrderConstraint {
	return ipo.constraints
}

func (ipo InProgressOrder) Deliver(deliveryAddress shared.Address, deliveryDate time.Time) (DeliveringOrder, error) {
	return NewDeliveringOrder(ipo, deliveryAddress, deliveryDate)
}
