all: tag

VERSION = $(shell cat composer.json | grep "version" | sed -e 's/^.*: "\(.*\)".*/\1/')
PWD = $(shell pwd)

DOCKER_REPO  = docker.wouterdeschuyter.be
PROJECT_NAME = internal-dropparty-api

TAG_NGINX = $(DOCKER_REPO)/$(PROJECT_NAME)-nginx
TAG_PHP_FPM = $(DOCKER_REPO)/$(PROJECT_NAME)-php-fpm

DOCKERFILE_NGINX = ./docker/nginx/Dockerfile
DOCKERFILE_PHP_FPM = ./docker/php-fpm/Dockerfile

clean:
	-rm -rf ./vendor
	-rm -f ./composer.phar
	-rm -f ./composer-setup.php

composer.phar:
	docker run --rm --volume=$(PWD):/code -w=/code php:7.2-alpine php -r 'copy("https://getcomposer.org/installer", "./composer-setup.php");'
	docker run --rm --volume=$(PWD):/code -w=/code php:7.2-alpine php ./composer-setup.php
	docker run --rm --volume=$(PWD):/code -w=/code php:7.2-alpine php -r 'unlink("./composer-setup.php");'

vendor: composer.phar composer.json composer.lock
	docker run --rm --volume=$(PWD):/code -w=/code php:7.2-alpine php ./composer.phar install --ignore-platform-reqs --prefer-dist --no-progress --optimize-autoloader

generate-migration: vendor
	docker exec -i internal-dropparty-api-php-fpm php ./composer.phar migrations:generate

migrate: vendor
	docker exec -i internal-dropparty-api-php-fpm php ./composer.phar migrations:migrate


.build-nginx: $(DOCKERFILE_NGINX)
	docker build $(BUILD_NO_CACHE) -f $(DOCKERFILE_NGINX) -t $(TAG_NGINX) .
	touch .build-nginx

.build-php-fpm: $(DOCKERFILE_PHP_FPM)
	docker build $(BUILD_NO_CACHE) -f $(DOCKERFILE_PHP_FPM) -t $(TAG_PHP_FPM) .
	touch .build-php-fpm

build: vendor .build-nginx .build-php-fpm

tag: build
	docker tag $(TAG_NGINX) $(TAG_NGINX):$(VERSION)
	docker tag $(TAG_PHP_FPM) $(TAG_PHP_FPM):$(VERSION)

push: tag
	docker push $(TAG_NGINX):$(VERSION)
	docker push $(TAG_PHP_FPM):$(VERSION)

push-latest: push
	docker push $(TAG_NGINX):latest
	docker push $(TAG_PHP_FPM):latest
