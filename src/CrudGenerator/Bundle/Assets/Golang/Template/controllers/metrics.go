package controllers

import (
	"{{ config.project.package }}/modules/config"

	"github.com/kataras/iris"
	"github.com/kataras/iris/context"
	"github.com/kataras/iris/middleware/basicauth"
	"github.com/kataras/iris/middleware/logger"
	"github.com/prometheus/client_golang/prometheus"
	"github.com/prometheus/client_golang/prometheus/promhttp"
	"time"
)

var buckets = []float64{100, 300, 500, 1000, 3000, 5000}

var httpReqs = prometheus.NewCounterVec(
	prometheus.CounterOpts{
		Name: "http_requests_total",
		Help: "How many HTTP requests processed, partitioned by status code and HTTP method.",
	},
	[]string{"code", "method", "path"},
)
var httpLatency = prometheus.NewHistogramVec(
	prometheus.HistogramOpts{
		Name:    "http_request_duration_milliseconds",
		Help:    "How long it took to process the request, partitioned by status code, method and HTTP path.",
		Buckets: buckets,
	},
	[]string{"code", "method", "path"},
)

func setupMetrics() {
	prometheus.MustRegister(httpReqs)
	prometheus.MustRegister(httpLatency)
}

func customLogger() context.Handler {
	customLogger := logger.New(logger.Config{
		Status: true,
		IP:     true,
		Method: true,
		LogFunc: func(now time.Time, latency time.Duration, status, ip, method, path string, message interface{}, headerMessage interface{}) {

			if path == "/metrics" {
				return
			}

			timeSince := float64(latency.Nanoseconds()) / 1000000.0
			httpReqs.WithLabelValues(status, method, "").Inc()
			httpLatency.WithLabelValues(status, method, "").Observe(timeSince)

		},
		Path: true,
	})

	return customLogger
}

// MetricsController ...
func MetricsController(app *iris.Application) {
	app.Use(customLogger())

	setupMetrics()

	authConfig := basicauth.Config{
		Users: map[string]string{
			config.Vars.Prometheus.Username: config.Vars.Prometheus.Password,
		},
		Expires: time.Duration(30) * time.Minute,
	}
	authentication := basicauth.New(authConfig)

	app.Get("/metrics",
		authentication,
		func(ctx iris.Context) {

			handler := promhttp.Handler()
			handler.ServeHTTP(ctx.ResponseWriter(), ctx.Request())

		})

}
