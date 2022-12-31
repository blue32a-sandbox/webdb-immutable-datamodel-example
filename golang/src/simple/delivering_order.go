package simple

import (
	"errors"
	"example/shared"
	"time"
)

type DeliveringOrder struct {
	orderId         string
	constraints     []shared.OrderConstraint
	deliveryAddress shared.Address
	deliveryDate    time.Time
}

func NewDeliveringOrder(order Order, deliveryAddress shared.Address, deliveryDate time.Time) (DeliveringOrder, error) {
	if err := validate(order.OrderId(), order.Constraints(), deliveryAddress, deliveryDate); err != nil {
		return DeliveringOrder{}, err
	}
	return DeliveringOrder{
		orderId:         order.OrderId(),
		constraints:     order.Constraints(),
		deliveryAddress: deliveryAddress,
		deliveryDate:    deliveryDate,
	}, nil
}

func validate(
	orderId string,
	constraints []shared.OrderConstraint,
	deliveryAddress shared.Address,
	deliveryDate time.Time) error {
	if orderId == "" {
		return errors.New("order id blank not allow")
	}

	if deliveryAddress.Country == "" {
		return errors.New("order requires delivery address")
	}

	if deliveryDate.Year() == 1 {
		return errors.New("order requires delivery date")
	}

	contains := func(s []shared.OrderConstraint, need shared.OrderConstraint) bool {
		for _, v := range s {
			if v == need {
				return true
			}
		}
		return false
	}

	if contains(constraints, shared.SHIPPING_JAPAN_ONLY) {
		if deliveryAddress.Country != "JP" {
			return errors.New(shared.SHIPPING_JAPAN_ONLY.ViolationMessage())
		}
	}

	if contains(constraints, shared.DELIVERY_WEEKDAY) {
		if deliveryDate.Weekday() == time.Sunday ||
			deliveryDate.Weekday() == time.Saturday {
			return errors.New(shared.DELIVERY_WEEKDAY.ViolationMessage())
		}
	}
	return nil
}

func (do *DeliveringOrder) OrderId() string {
	return do.orderId
}

func (do *DeliveringOrder) Constraints() []shared.OrderConstraint {
	return do.constraints
}

func (do *DeliveringOrder) Close() ClosedOrder {
	return ClosedOrder{orderId: do.OrderId(), constraints: do.Constraints()}
}
