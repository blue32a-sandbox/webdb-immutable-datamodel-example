package simple

type OrderClosable interface {
	Close() ClosedOrder
}
