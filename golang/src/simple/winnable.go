package simple

type Winnable interface {
	Win(productSerialNo string) WinningOrder
}
