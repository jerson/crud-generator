// Package validator ...
package validator

import (
	"github.com/asaskevich/govalidator"
)

// Validate ...
func Validate(data interface{}) error {
	_, err := govalidator.ValidateStruct(data)
	if err != nil {
		return err
	}
	return nil
}
