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

// main autoload
if ($autoload = realpath('./vendor/autoload.php')) {
    require_once $autoload;
} else {
    echo 'Please execute "composer update" !' . PHP_EOL;
    exit(1);
}

// Browser emulator
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['HTTP_HOST']       = 'domain.com';
$_SERVER['SERVER_NAME']     = 'domain.com';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_SERVER['REMOTE_ADDR']     = '127.0.0.1';

$PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

// include CMS framework
if ($cmsPath = getenv('PATH_JOOMLA')) {
    define('CMS_JOOMLA_PATH', realpath($cmsPath));
    require_once __DIR__ . '/autoload-joomla.php';

} elseif ($cmsPath = getenv('PATH_WORDPRESS')) {
    define('CMS_WORDPRESS_PATH', realpath($cmsPath));
    require_once __DIR__ . '/autoload-wordpress.php';

} else {
    echo 'Undefined CMS type!' . PHP_EOL;
    exit(1);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('magic_quotes_runtime', 0);
ini_set('zend.ze1_compatibility_mode', '0');
ini_set('precision', 14);
