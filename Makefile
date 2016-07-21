.PHONY: build test

build:
	composer self-update --no-interaction
	composer update --optimize-autoloader --no-interaction
	make prepare

test:
	composer phpunit-joomla
	composer phpunit-wordpress

test-all:
	composer test

prepare:
	composer prepare-joomla
	composer prepare-wordpress
