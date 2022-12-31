package complex

type OrderStatus int

const (
	IN_PROGRESS OrderStatus = iota
	DELIVERING
	CLOSED
)
