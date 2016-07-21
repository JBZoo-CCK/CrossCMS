build:
	prepare
	composer self-update --no-interaction
	composer update --optimize-autoloader --no-interaction

test:
	composer phpunit-joomla
	composer phpunit-wordpress

test-all:
	composer test

prepare:
	composer prepare-joomla
	composer prepare-wordpress
