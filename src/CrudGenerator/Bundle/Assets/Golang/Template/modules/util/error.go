package util

import (
	"fmt"
	"strings"
)

//GetErrorStack ...
func GetErrorStack(err error) []string {
	return strings.Split(strings.Replace(fmt.Sprintf("%+v", err), "\t", "=> ", -1), "\n")
}
