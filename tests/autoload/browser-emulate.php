<?php
/**
 * JBZoo CrossCMS
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CrossCMS
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 */

// Web-server emulator
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['SERVER_NAME']     = 'crosscms.com';
$_SERVER['DOCUMENT_ROOT']   = realpath('.');

// Local host
$_SERVER['REMOTE_ADDR']     = '127.0.0.1';
$_SERVER['SERVER_PORT']     = '127.0.0.1';
$_SERVER['REMOTE_PORT']     = '54778';
$_SERVER['SERVER_SOFTWARE'] = 'Apache/2.2.29';

// HTTP headers
$_SERVER['HTTP_HOST']            = 'crosscms.com';
$_SERVER['HTTP_ACCEPT']          = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
$_SERVER['HTTP_USER_AGENT']      = 'JBZoo PHPUnit Tester';
$_SERVER['HTTP_CONNECTION']      = 'keep-alive';
$_SERVER['HTTP_CACHE_CONTROL']   = 'max-age=0';
$_SERVER['HTTP_ACCEPT_ENCODING'] = 'gzip, deflate, sdch';
$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4';

// request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI']    = '/';
$_SERVER['QUERY_STRING']   = '';

$PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'] = '/index.php';

unset($_SERVER['argv']);
unset($_SERVER['argc']);
