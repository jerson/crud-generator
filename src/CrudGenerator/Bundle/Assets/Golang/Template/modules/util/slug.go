package util

import (
	"github.com/gosimple/slug"
	"strings"
)

// Slug ...
func Slug(text string) string {
	slugText := slug.Make(strings.Replace(text, " - ", " ", -1))
	return slugText
}
