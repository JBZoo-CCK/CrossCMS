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

use JBZoo\Utils\FS;

require_once realpath('./vendor/autoload.php');

$configPath = FS::real('./resources/joomla/configuration.php');

if ($configPath) {
    $config = FS::openFile($configPath);
    $config = preg_replace('#\'smtp\'#ius', "'mail'", $config);
    $config = preg_replace('#\'default\'#ius', "'development'", $config);

    file_put_contents($configPath, $config);

} else {
    throw new \Exception('Joomla configuration file not found!');
}
