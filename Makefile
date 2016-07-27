#
# JBZoo CrossCMS
#
# This file is part of the JBZoo CCK package.
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
# @package   CrossCMS
# @license   MIT
# @copyright Copyright (C) JBZoo.com,  All rights reserved.
# @link      https://github.com/JBZoo/CrossCMS
#

.PHONY: build test tests

build:
	@make update
	@make prepare

prepare:
	@make prepare-fs
	@make prepare-joomla
	@make prepare-wordpress

test:
	@make test-joomla
	@make test-wordpress

update:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m \033[0;30;46m Update project \033[0m"
	@composer update --optimize-autoloader --no-interaction
	@echo ""

prepare-fs:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Prepare Filesystem \033[0m"
	@mkdir -p ./build
	@mkdir -p ./build/logs
	@mkdir -p ./build/clover
	@mkdir -p ./resource

prepare-joomla:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Prepare Joomla! CMS before tests \033[0m"
	@php ./vendor/joomlatools/console/bin/joomla site:create joomla --www=./resources --mysql-login=root: --mysql-host=127.0.0.1 --mysql-database=test_cms_j --verbose
	@php ./vendor/joomlatools/console/bin/joomla extension:disable joomla debug --www=./resources
	@php ./tests/bin/prepare-joomla-config.php
	@zip -rj ./build/joomla-plugin.zip tests/extentions/joomla-plugin
	@php ./vendor/joomlatools/console/bin/joomla extension:installfile joomla ./build/joomla-plugin.zip --www=./resources
	@php ./vendor/joomlatools/console/bin/joomla extension:enable joomla jbzoophpunit --www=./resources

prepare-wordpress:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Prepare Wordpress CMS before tests \033[0m"
	@mkdir -p ./resources/wordpress
	@mysql -e 'create database test_cms_wp'
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php core download --path=./resources/wordpress
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php core config --path=./resources/wordpress --dbname=test_cms_wp --dbuser=root --dbhost=127.0.0.1
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php core install --path=./resources/wordpress --url=crosscms.com --title=CrossCMS --admin_user=admin --admin_password=123456 --admin_email=admin@example.com
	@mkdir -p ./resources/wordpress/cache
	@mkdir -p ./resources/wordpress/tmp
	@mkdir -p ./resources/wordpress/logs
	@zip -rj ./build/wp-plugin.zip tests/extentions/wp-plugin
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php plugin install --path=./resources/wordpress ./build/wp-plugin.zip --force
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php plugin activate wp-plugin --path=./resources/wordpress

test-all:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run all tests \033[0m"
	@make validate test phpmd phpcs phpcpd phploc
	@echo ""

validate:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Composer validate \033[0m"
	@composer validate --no-interaction
	@echo ""

autoload:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Composer autoload \033[0m"
	@composer dump-autoload --optimize --no-interaction
	@echo ""

test-joomla:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run unit-tests for Joomla! CMS \033[0m"
	@php ./vendor/phpunit/phpunit/phpunit --configuration ./phpunit-joomla.xml.dist
	@echo ""

test-wordpress:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run unit-tests for Wordpress \033[0m"
	@php ./vendor/phpunit/phpunit/phpunit --configuration ./phpunit-wordpress.xml.dist
	@echo ""

phpmd:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Check PHPmd \033[0m"
	@php ./vendor/phpmd/phpmd/src/bin/phpmd ./src text  \
         ./vendor/jbzoo/misc/phpmd/jbzoo.xml --verbose

phpcs:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Check Code Style \033[0m"
	@php ./vendor/squizlabs/php_codesniffer/scripts/phpcs ./src  \
        --extensions=php                                         \
        --standard=./vendor/jbzoo/misc/phpcs/JBZoo/ruleset.xml   \
        --report=full
	@echo ""

phpcpd:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Check Copy&Paste \033[0m"
	@php ./vendor/sebastian/phpcpd/phpcpd ./src --verbose
	@echo ""

phploc:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Show statistic \033[0m"
	@php ./vendor/phploc/phploc/phploc ./src --verbose
	@echo ""

reset:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Hard reset \033[0m"
	@git reset --hard

coveralls:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Send coverage to coveralls.io \033[0m"
	@php ./vendor/satooshi/php-coveralls/bin/coveralls --verbose
	@echo ""
