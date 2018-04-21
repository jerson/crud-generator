package util

import "github.com/rs/xid"

// UniqueID ...
func UniqueID() string {
	guid := xid.New()
	return guid.String()
}
