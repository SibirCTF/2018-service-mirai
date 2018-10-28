FROM postgres:10

ENV POSTGRES_PASSWORD=mem

COPY ./database.sql /docker-entrypoint-initdb.d
