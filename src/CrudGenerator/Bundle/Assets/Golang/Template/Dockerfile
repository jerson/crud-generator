FROM jerson/go:1.10 AS builder

ENV WORKDIR ${GOPATH}/src/{{ config.project.package }}
WORKDIR ${WORKDIR}

COPY Gopkg.toml Gopkg.lock Makefile ./
RUN make deps

USER root

COPY config.toml-dist config.toml
COPY . .

RUN make build

FROM jerson/base:1.0

LABEL maintainer="jeral17@gmail.com"

ENV BUILDER_PATH /srv/go/src/{{ config.project.package }}
ENV WORKDIR /app
WORKDIR ${WORKDIR}

COPY --from=builder ${BUILDER_PATH}/conf ./conf
COPY --from=builder ${BUILDER_PATH}/config.toml .
COPY --from=builder ${BUILDER_PATH}/api-server .

EXPOSE 8000
VOLUME ["${WORKDIR}/logs"]

ENTRYPOINT ["/app/api-server"]