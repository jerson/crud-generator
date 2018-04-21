package context

import (
	"github.com/sirupsen/logrus"
	"net/http"
)

// Context ...
type Context interface {
	init()
	Close()
	GetToken() string
	SetUser(id int)
	GetLogger(tag string) *logrus.Entry
	Request() *http.Request
	Response() http.ResponseWriter
	ReadForm(formObject interface{}) error
	BindRequest(object, formObject interface{}) interface{}
	StatusCode(status int)
	Header(name, value string)
	GetHeader(name string) string
	Next()
	Stop()
	Set(name string, value interface{})
	Get(name string) interface{}
	GetParamInt64(name string) (int64, error)
	GetParamInt(name string) (int, error)
	GetParamFloat64(name string) (float64, error)
	GetParam(name string) string
	GetURLParam(name string) string
	GetURLParamFloat64(name string) (float64, error)
	GetURLParamInt(name string) (int, error)
	SendError(status int, err error) error
	SendResponse(status int, data interface{}) error
	SendCacheResponse(status int, data interface{}, key string) error
	SendRawResponse(status int, data []byte) error
	GetCacheResponse(key string) ([]byte, error)
}

// Base ...
type Base interface {
	Set(name string, value interface{})
	Get(name string) interface{}
	Close()
	GetToken() string
	SetUser(id int)
	GetLogger(tag string) *logrus.Entry
}
