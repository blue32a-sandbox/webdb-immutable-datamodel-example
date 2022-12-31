package simple

import (
	"example/shared"
	"strings"
	"testing"
	"time"
)

func TestDeliverWithNoConstraint(t *testing.T) {
	inProgressOrder := InProgressOrder{orderId: "1", constraints: []shared.OrderConstraint{}}
	deliveringOrder, err := inProgressOrder.Deliver(shared.Address{Country: "JP", PostalCode: "1234567", Region: "Tokyo", StreetAddress: "Suginami-ku"}, time.Now())
	if err != nil {
		t.Fatalf(err.Error())
	}
	if deliveringOrder.OrderId() != "1" {
		t.Fatalf("order id is not 1")
	}
}

func TestDeliverWithJPOnly(t *testing.T) {
	inProgressOrder := InProgressOrder{orderId: "1", constraints: []shared.OrderConstraint{shared.SHIPPING_JAPAN_ONLY}}
	_, err := inProgressOrder.Deliver(shared.Address{Country: "US", PostalCode: "7654321", Region: "United States", StreetAddress: "New York City"}, time.Now())
	if err == nil {
		t.Fatalf("no error")
	}
	if !strings.Contains(err.Error(), "shipping only for Japan") {
		t.Fatalf("unexpected error")
	}
}

func TestOrderClose(t *testing.T) {
	inProgressOrder := InProgressOrder{orderId: "1", constraints: []shared.OrderConstraint{}}
	deliveringOrder, err := inProgressOrder.Deliver(shared.Address{Country: "JP", PostalCode: "1234567", Region: "Tokyo", StreetAddress: "Suginami-ku"}, time.Now())
	if err != nil {
		t.Fatalf(err.Error())
	}
	closedOrder := deliveringOrder.Close()
	if closedOrder.OrderId() != "1" {
		t.Fatalf("order id is not 1")
	}
}

func TestLotteryOrderToDeliver(t *testing.T) {
	lotteryOrder := LotteryOrder{orderId: "1", constraints: []shared.OrderConstraint{}}
	winningOrder := lotteryOrder.Win("1234")
	deliveringOrder, err := winningOrder.Deliver(shared.Address{Country: "JP", PostalCode: "1234567", Region: "Tokyo", StreetAddress: "Suginami-ku"}, time.Now())
	if err != nil {
		t.Fatalf(err.Error())
	}
	if deliveringOrder.OrderId() != "1" {
		t.Fatalf("order id is not 1")
	}
}
