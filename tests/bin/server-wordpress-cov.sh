#!/usr/bin/env sh

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

DIR="."
WEB_HOST="127.0.0.1"
WEB_PORT="8083"
WEB_ROOT="$DIR/resources/wordpress"
WEB_PATH="$DIR/tests/bin/fake-index.php"

php56-x -S "$WEB_HOST:$WEB_PORT" -t "$WEB_ROOT" "$WEB_PATH" &

sleep 3s
