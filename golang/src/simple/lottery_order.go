package simple

import "example/shared"

type LotteryOrder struct {
	orderId     string
	constraints []shared.OrderConstraint
}

func (lo LotteryOrder) OrderId() string {
	return lo.orderId
}

func (lo LotteryOrder) Constraints() []shared.OrderConstraint {
	return lo.constraints
}

func (lo LotteryOrder) Win(productSerialNo string) WinningOrder {
	return WinningOrder{orderId: lo.OrderId(), constraints: lo.Constraints(), productSerialNo: productSerialNo}
}
