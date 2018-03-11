VERSION = $(shell cat composer.json | grep "version" | sed -e 's/^.*: "\(.*\)".*/\1/')
PWD = $(shell pwd)

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
