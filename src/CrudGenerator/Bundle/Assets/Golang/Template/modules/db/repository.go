// Package db ...
package db

import (
	"github.com/jinzhu/gorm"
	"{{ config.project.package }}/modules/context"
	"{{ config.project.package }}/modules/util"
)

// BaseRepository ...
type BaseRepository struct {
	ctx context.Base
	cn  *gorm.DB
}

// NewBaseRepository ...
func NewBaseRepository(ctx context.Base) BaseRepository {
	return BaseRepository{ctx: ctx}
}

// DB ...
func (b *BaseRepository) DB() (*gorm.DB, error) {
	if b.cn != nil {
		return b.cn, nil
	}

	old := b.ctx.Get("DB")
	if old != nil {
		b.cn = old.(*gorm.DB)
		return b.cn, nil
	}

	cn, err := Setup(b.ctx)
	if err != nil {
		return nil, err
	}
	b.cn = cn
	b.ctx.Set("DB", b.cn)
	return b.cn, err

}

// SetDB ...
func (b *BaseRepository) SetDB(cn *gorm.DB) {
	b.cn = cn
}

// Close ...
func (b *BaseRepository) Close() {
	//TODO do something need to close here please
}

// DiffStruct ...
func (b BaseRepository) DiffStruct(from, to interface{}) map[string]interface{} {
	return util.DiffStruct(from, to)
}
