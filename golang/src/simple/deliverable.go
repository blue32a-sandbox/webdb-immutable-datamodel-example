package simple

import (
	"example/shared"
	"time"
)

type Deliverable interface {
	Deliver(deliveryAddress shared.Address, deliveryDate time.Time) (DeliveringOrder, error)
}
