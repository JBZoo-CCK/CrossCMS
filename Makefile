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
	@make prepare-j
	@make prepare-wp

server:
	@make server-j
	@make server-wp

server-cov:
	@make server-j-cov
	@make server-wp-cov

test:
	@make test-j
	@make test-wp

test-cov:
	@make test-j-cov
	@make test-wp-cov

update:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Update project \033[0m"
	@composer update --optimize-autoloader --no-interaction
	@echo ""

server-wp:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Start Wordpress Web-server \033[0m"
	@chmod +x ./tests/bin/server-wordpress.sh
	@./tests/bin/server-wordpress.sh

server-wp-cov:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Start Wordpress Web-server with Xdebug \033[0m"
	@chmod +x ./tests/bin/server-wordpress-cov.sh
	@./tests/bin/server-wordpress-cov.sh

server-j:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Start Joomla Web-server \033[0m"
	@chmod +x ./tests/bin/server-joomla.sh
	@./tests/bin/server-joomla.sh

server-j-cov:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Start Joomla Web-server with Xdebug \033[0m"
	@chmod +x ./tests/bin/server-joomla-cov.sh
	@./tests/bin/server-joomla-cov.sh

prepare-fs:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Prepare Filesystem \033[0m"
	@mkdir -pv ./build
	@mkdir -pv ./build/logs
	@mkdir -pv ./build/total
	@mkdir -pv ./build/clover
	@mkdir -pv ./build/coverage_cov
	@mkdir -pv ./resource

prepare-j:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Prepare Joomla! CMS before tests \033[0m"
	@php ./vendor/joomlatools/console/bin/joomla site:create joomla \
            --www=./resources                                       \
            --mysql-login=root:                                     \
            --mysql-host=127.0.0.1                                  \
            --mysql-database=test_cms_j                             \
            --verbose
	@php ./vendor/joomlatools/console/bin/joomla extension:disable joomla debug \
        --www=./resources
	@php ./tests/bin/prepare-joomla-config.php
	@zip -rj ./build/joomla-plugin.zip tests/extentions/joomla-plugin
	@php ./vendor/joomlatools/console/bin/joomla extension:installfile joomla   \
            ./build/joomla-plugin.zip                                           \
            --www=./resources
	@php ./vendor/joomlatools/console/bin/joomla extension:enable joomla jbzoophpunit \
            --www=./resources

prepare-wp:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Prepare Wordpress CMS before tests \033[0m"
	@mkdir -p ./resources/wordpress
	@mysql -e 'create database test_cms_wp'
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php core download \
            --path=./resources/wordpress
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php core config \
            --path=./resources/wordpress                    \
            --dbname=test_cms_wp                            \
            --dbuser=root                                   \
            --dbhost=127.0.0.1
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php core install    \
            --path=./resources/wordpress                        \
            --url=127.0.0.1:8083                                \
            --title=CrossCMS                                    \
            --admin_user=admin                                  \
            --admin_password=123456                             \
            --admin_email=admin@example.com
	@mkdir -p ./resources/wordpress/cache
	@mkdir -p ./resources/wordpress/tmp
	@mkdir -p ./resources/wordpress/logs
	@zip -rj ./build/wp-plugin.zip tests/extentions/wp-plugin
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php plugin install  \
            --path=./resources/wordpress                        \
            ./build/wp-plugin.zip                               \
            --force
	@php ./vendor/wp-cli/wp-cli/php/boot-fs.php plugin activate wp-plugin \
            --path=./resources/wordpress

test-other:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run all tests \033[0m"
	@make validate phpmd phpcs phpcpd phploc
	@echo ""

validate:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Composer validate \033[0m"
	@composer validate --no-interaction
	@echo ""

autoload:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Composer autoload \033[0m"
	@composer dump-autoload --optimize --no-interaction
	@echo ""

test-j:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run unit-tests for Joomla! CMS \033[0m"
	@php ./vendor/phpunit/phpunit/phpunit --configuration ./phpunit-joomla.xml.dist
	@echo ""

test-j-cov:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run unit-tests for Joomla! CMS  with Xdebug \033[0m"
	@php56-x ./vendor/phpunit/phpunit/phpunit --configuration ./phpunit-joomla.xml.dist
	@echo ""

test-wp:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run unit-tests for Wordpress \033[0m"
	@php ./vendor/phpunit/phpunit/phpunit --configuration ./phpunit-wordpress.xml.dist
	@echo ""

test-wp-cov:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Run unit-tests for Wordpress with Xdebug \033[0m"
	@php56-x ./vendor/phpunit/phpunit/phpunit --configuration ./phpunit-wordpress.xml.dist
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

phpcov:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Merge coverage reports \033[0m"
	@php ./vendor/phpunit/phpcov/phpcov merge \
        --clover build/total/total.xml        \
        build/coverage_cov                    \
        -v
	@echo ""

coveralls:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Send coverage to coveralls.io \033[0m"
	@php ./vendor/satooshi/php-coveralls/bin/coveralls -vvv
	@echo ""

coveralls-test:
	@echo -e "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Send coverage to coveralls.io \033[0m"
	@php ./vendor/satooshi/php-coveralls/bin/coveralls -vvv --dry-run
	@echo ""
