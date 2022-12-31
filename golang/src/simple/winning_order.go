package simple

import (
	"example/shared"
	"time"
)

type WinningOrder struct {
	orderId         string
	constraints     []shared.OrderConstraint
	productSerialNo string
}

func (wo WinningOrder) OrderId() string {
	return wo.orderId
}

func (wo WinningOrder) Constraints() []shared.OrderConstraint {
	return wo.constraints
}

func (wo WinningOrder) Deliver(deliveryAddress shared.Address, deliveryDate time.Time) (DeliveringOrder, error) {
	return NewDeliveringOrder(wo, deliveryAddress, deliveryDate)
}
