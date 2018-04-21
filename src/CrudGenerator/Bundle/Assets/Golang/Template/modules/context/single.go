package context

import (
	"context"
	"github.com/jinzhu/gorm"
	"{{ config.project.package }}/modules/config"
	"{{ config.project.package }}/modules/util"
)

// Single ...
type Single struct {
	template
	Context context.Context
	Data    map[string]interface{}
}

// NewSingle ...
func NewSingle(category string) *Single {
	parser := &Single{Context: context.Background(), template: template{Category: category}}
	parser.init()
	return parser
}

// init ...
func (r *Single) init() {
	r.Data = map[string]interface{}{}
	r.Token = util.UniqueID()
}

// Close ...
func (r *Single) Close() {
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

// Set ...
func (r *Single) Set(name string, value interface{}) {
	r.Data[name] = value
}

// Get ...
func (r Single) Get(name string) interface{} {
	return r.Data[name]
}
