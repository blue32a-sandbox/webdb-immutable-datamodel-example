package complex

import (
    "errors"
    "example/shared"
    "time"
)

type Order struct {
    status          OrderStatus
    orderId         string
    constraints     []shared.OrderConstraint
    deliveryAddress shared.Address
    deliveryDate    time.Time
}

func NewOrder(orderId string, constraints []shared.OrderConstraint) Order {
    return Order{
        orderId:     orderId,
        constraints: constraints,
        status:      IN_PROGRESS,
    }
}

func validate(o Order) error {
    if o.deliveryAddress.Country == "" {
        return errors.New("order requires delivery address")
    }
    if o.deliveryDate.Year() == 1 {
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

    if contains(o.constraints, shared.SHIPPING_JAPAN_ONLY) {
        if o.deliveryAddress.Country != "JP" {
            return errors.New(shared.SHIPPING_JAPAN_ONLY.ViolationMessage())
        }
    }

    if contains(o.constraints, shared.DELIVERY_WEEKDAY) {
        if o.deliveryDate.Weekday() == time.Sunday ||
            o.deliveryDate.Weekday() == time.Saturday {
            return errors.New(shared.DELIVERY_WEEKDAY.ViolationMessage())
        }
    }

    return nil
}

func (o *Order) Deliver(deliveryAddress shared.Address, deliveryDate time.Time) error {
    if o.status != IN_PROGRESS {
        return errors.New("order status is not in progress")
    }

    o.deliveryAddress = deliveryAddress
    o.deliveryDate = deliveryDate
    o.status = DELIVERING

    return validate(*o)
}

func (o *Order) Close() error {
    if o.status != DELIVERING {
        return errors.New("order status is not delivering")
    }

    o.status = CLOSED

    return nil
}

func (o *Order) GetStatus() OrderStatus {
    return o.status
}

func (o *Order) GetOrderId() string {
    return o.orderId
}

func (o *Order) GetConstraints() []shared.OrderConstraint {
    return o.constraints
}

func (o *Order) GetDeliveryAddress() shared.Address {
    return o.deliveryAddress
}

func (o *Order) getDeliveryDate() time.Time {
    return o.deliveryDate
}
