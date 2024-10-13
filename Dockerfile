FROM php:8.0-fpm-alpine

RUN curl --request GET -sL \
--url 'http://example.com'\
--output './path/to/file'
