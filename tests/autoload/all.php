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
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

require_once __DIR__ . '/composer.php';
require_once __DIR__ . '/browser-emulate.php';

// include CMS framework
$isWeb = defined('JBZOO_PHPUNIT_BROWSER') && JBZOO_PHPUNIT_BROWSER;
if (!$isWeb) {

    if ($cmsPath = getenv('PATH_JOOMLA')) {
        define('CMS_PATH_JOOMLA', realpath($cmsPath));
        define('CMS_PATH', CMS_PATH_JOOMLA);
        require_once __DIR__ . '/cms-joomla.php';

    } elseif ($cmsPath = getenv('PATH_WORDPRESS')) {
        define('CMS_PATH_WORDPRESS', realpath($cmsPath));
        define('CMS_PATH', CMS_PATH_WORDPRESS);
        require_once __DIR__ . '/cms-wordpress.php';

    } else {
        echo 'Undefined CMS type!' . PHP_EOL;
        exit(1);
    }
}

// Forsed show PHP errors
require_once __DIR__ . '/errors.php';
require_once __DIR__ . '/../tests/CrossCMS.php';
