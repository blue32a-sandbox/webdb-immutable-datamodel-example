package simple

import "example/shared"

type Order interface {
	OrderId() string
	Constraints() []shared.OrderConstraint
}
