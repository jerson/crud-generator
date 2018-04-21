// Package db ...
package db

import (
	"fmt"
	"github.com/jinzhu/gorm"
	"github.com/sirupsen/logrus"
	"{{ config.project.package }}/modules/config"
	"{{ config.project.package }}/modules/context"
	"time"
)

// SetupContext ...
func SetupContext(ctx context.Base) (*gorm.DB, error) {
	log := ctx.GetLogger("DB.gorm.SetupContext")
	i := 0
	limit := 20
	for {
		i++
		cn, err := SingleSetupContext(ctx)
		if err == nil || i > limit {
			if i <= limit && i > 1 {
				log.Info("mysql gorm recuperado")
			}
			return cn, err
		}
		time.Sleep(time.Millisecond * 200)
		log.Warn("mysql gorm lag, reconectando...")

	}
}

// SingleSetupContext ...
func SingleSetupContext(ctx context.Base) (*gorm.DB, error) {

	name := config.Vars.Database.Name
	user := config.Vars.Database.User
	password := config.Vars.Database.Password
	host := config.Vars.Database.Host
	port := config.Vars.Database.Port

	cn, err := gorm.Open("mysql", fmt.Sprintf(
		"%s:%s@tcp(%s:%d)/%s?charset=utf8mb4&parseTime=True&loc=Local",
		user,
		password,
		host,
		port,
		name,
	))
	if err != nil {
		return cn, err
	}

	cn.InstantSet("gorm:save_associations", false)
	cn.LogMode(false)

	return cn, nil
}

// Logger ...
type Logger struct {
	Instance *logrus.Entry
}

// Print ...
func (logger Logger) Print(values ...interface{}) {
	logger.Instance.Error(values)
}
