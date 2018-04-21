package context

import (
	"github.com/jinzhu/gorm"
	json "github.com/json-iterator/go"
	"github.com/juju/errors"
	"github.com/kataras/iris"
	"net/http"
	"{{ config.project.package }}/modules/cache"
	"{{ config.project.package }}/modules/config"
	"{{ config.project.package }}/modules/util"
	"strconv"
)

// Iris ...
type Iris struct {
	template
	Context iris.Context
}

// NewIris ...
func NewIris(ctx iris.Context, category string) *Iris {
	parser := &Iris{Context: ctx, template: template{Category: category}}
	parser.init()
	return parser
}

// init ...
func (r *Iris) init() {
	r.Token = util.UniqueID()
}

// Close ...
func (r Iris) Close() {
	db := r.Get("DB")
	if db != nil {
		cn := db.(*gorm.DB)
		cn.Close()
		//r.Set("DB", nil)
		if config.Vars.Debug {
			r.GetLogger("DB").Debug("conexion cerrada")
		}
	}
}

// Request ...
func (r Iris) Request() *http.Request {
	return r.Context.Request()
}

// Response ...
func (r Iris) Response() http.ResponseWriter {
	return r.Context.ResponseWriter()
}

// ReadForm ...
func (r Iris) ReadForm(formObject interface{}) error {
	r.Context.Request().ParseForm()
	err := decoder.Decode(&formObject, r.Context.Request().PostForm)
	if err != nil {
		r.GetLogger("ReadForm").Panic(err)
	}
	return err
}

// BindRequest ...
func (r Iris) BindRequest(object, formObject interface{}) interface{} {
	util.BindStruct(object, formObject)
	return object
}

// StatusCode ...
func (r Iris) StatusCode(status int) {
	r.Response().WriteHeader(status)
}

// Header ...
func (r Iris) Header(name, value string) {
	r.Response().Header().Set(name, value)
}

// GetHeader ...
func (r Iris) GetHeader(name string) string {
	return r.Request().Header.Get(name)
}

// Next ...
func (r Iris) Next() {
	r.Context.Next()
}

// Stop ...
func (r Iris) Stop() {
	r.Context.StopExecution()
}

// Set ...
func (r *Iris) Set(name string, value interface{}) {
	r.Context.Values().Set(name, value)
}

// Get ...
func (r Iris) Get(name string) interface{} {
	return r.Context.Values().Get(name)
}

// GetParamInt64 ...
func (r Iris) GetParamInt64(name string) (int64, error) {
	return strconv.ParseInt(r.GetParam(name), 10, 0)
}

// GetParamInt ...
func (r Iris) GetParamInt(name string) (int, error) {
	return strconv.Atoi(r.GetParam(name))
}

// GetParamFloat64 ...
func (r Iris) GetParamFloat64(name string) (float64, error) {
	return strconv.ParseFloat(r.GetParam(name), 64)
}

// GetParam ...
func (r Iris) GetParam(name string) string {
	return r.Context.Params().Get(name)
}

// GetURLParam ...
func (r Iris) GetURLParam(name string) string {
	return r.Context.URLParam(name)
}

// GetURLParamFloat64 ...
func (r Iris) GetURLParamFloat64(name string) (float64, error) {
	return strconv.ParseFloat(r.GetURLParam(name), 64)
}

// GetURLParamInt ...
func (r Iris) GetURLParamInt(name string) (int, error) {

	value := r.GetURLParam(name)
	if name == "limit" {
		limit, err := strconv.Atoi(value)

		if limit < 1 {
			limit = 200
		}
		if limit > 500 {
			limit = 500
		}
		return limit, err
	} else if name == "offset" {
		offset, err := strconv.Atoi(value)

		if offset < 0 {
			offset = 0
		}
		return offset, err
	}

	return strconv.Atoi(value)
}

// SendError ...
func (r Iris) SendError(status int, err error) error {

	if config.Vars.Debug {
		return r.SendResponse(status, map[string]interface{}{
			"code":    status,
			"message": err.Error(),
			"stack":   util.GetErrorStack(err),
			"id":      r.Token,
		})
	}
	log := r.GetLogger("SendError")
	if status < 500 {
		log.Warn(err)
	} else {
		log.Error(err)
	}
	r.SendResponse(status, map[string]interface{}{
		"code":    status,
		"message": "error",
		"id":      r.Token,
	})
	return nil
}

// SendResponse ...
func (r Iris) SendResponse(status int, data interface{}) error {
	log := r.GetLogger("SendResponse")

	r.StatusCode(status)
	r.Header("Content-Type", "application/json; charset=utf-8")
	response := r.Response()
	content, err := json.Marshal(data)
	if err != nil {
		log.Error(err)
		http.Error(response, errors.New("error al serializar").Error(), http.StatusInternalServerError)
		return err
	}
	response.Write([]byte(content))
	return nil
}

// SendCacheResponse ...
func (r Iris) SendCacheResponse(status int, data interface{}, key string) error {

	log := r.GetLogger("SendCacheResponse")
	r.StatusCode(status)
	r.Header("Content-Type", "application/json; charset=utf-8")
	response := r.Response()
	content, err := json.Marshal(data)
	if err != nil {
		log.Error(err)
		http.Error(response, errors.New("error al serializar").Error(), http.StatusInternalServerError)
		return err
	}

	if config.Vars.Cache.Enable {
		// FIXME cache para esto
		client, _ := cache.Connect()
		if client != nil {
			err := client.Set(key, content)
			if err != nil {
				log.Warn(err)
			}
		}
	}

	response.Write([]byte(content))
	return nil

}

// SendRawResponse ...
func (r Iris) SendRawResponse(status int, data []byte) error {
	r.StatusCode(status)
	r.Header("Content-Type", "application/json; charset=utf-8")
	r.Response().Write(data)
	return nil
}
