package complex

import (
	"example/shared"
	"testing"
	"time"
)

func TestDeliverWithNoConstraint(t *testing.T) {
	sut := NewOrder("1", []shared.OrderConstraint{})
	if sut.status != IN_PROGRESS {
		t.Fatalf("order status is not in progress")
	}
	err := sut.Deliver(shared.Address{Country: "JP", PostalCode: "1234567", Region: "Tokyo", StreetAddress: "Suginami-ku"}, time.Now())
	if err != nil {
		t.Fatalf(err.Error())
	}
	if sut.status != DELIVERING {
		t.Fatalf("order status is not delivering")
	}
}

func TestDeliverWithJPOnly(t *testing.T) {
	sut := NewOrder("1", []shared.OrderConstraint{shared.SHIPPING_JAPAN_ONLY})
	err := sut.Deliver(shared.Address{Country: "US", PostalCode: "7654321", Region: "United States", StreetAddress: "New York City"}, time.Now())
	if err == nil {
		t.Fatalf("shipping only for Japan")
	}
}
