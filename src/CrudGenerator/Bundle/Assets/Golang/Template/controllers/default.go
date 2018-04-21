// Package controllers ...
package controllers

import (
	"{{ config.project.package }}/modules/context"
	"github.com/juju/errors"
	"github.com/kataras/iris"
	"net/http"
)

// BaseController ...
func BaseController(app *iris.Application) {

	app.OnErrorCode(http.StatusInternalServerError,
		func(c iris.Context) {
			ctx := context.NewIris(c, "OnErrorCode.StatusInternalServerError")
			defer ctx.Close()
			ctx.SendError(http.StatusInternalServerError, errors.New("internal error"))
		})

	app.OnErrorCode(http.StatusNotFound,
		func(c iris.Context) {
			ctx := context.NewIris(c, "OnErrorCode.StatusNotFound")
			defer ctx.Close()
			ctx.SendError(http.StatusNotFound, errors.NotFoundf(ctx.Request().URL.String()))
		})

	app.OnErrorCode(http.StatusBadRequest,
		func(c iris.Context) {
			ctx := context.NewIris(c, "OnErrorCode.StatusBadRequest")
			defer ctx.Close()
			ctx.SendError(http.StatusBadRequest, errors.BadRequestf(""))
		})

	app.OnErrorCode(http.StatusUnauthorized,
		func(c iris.Context) {
			ctx := context.NewIris(c, "OnErrorCode.StatusUnauthorized")
			defer ctx.Close()
			ctx.SendError(http.StatusUnauthorized, errors.UserNotFoundf(""))
		})

}
