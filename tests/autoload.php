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

include_once 'web.php';

$isWeb = defined('WEB_EMULATE') && WEB_EMULATE;

// include CMS framework
if (!$isWeb) {

    if ($cmsPath = getenv('PATH_JOOMLA')) {
        define('CMS_JOOMLA_PATH', realpath($cmsPath));
        define('CMS_PATH', CMS_JOOMLA_PATH);
        require_once __DIR__ . '/autoload-joomla.php';

    } elseif ($cmsPath = getenv('PATH_WORDPRESS')) {
        define('CMS_WORDPRESS_PATH', realpath($cmsPath));
        define('CMS_PATH', CMS_WORDPRESS_PATH);
        require_once __DIR__ . '/autoload-wordpress.php';

    } else {
        echo 'Undefined CMS type!' . PHP_EOL;
        exit(1);
    }
}

include_once 'show-errors.php';
