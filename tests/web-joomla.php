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


define('WEB_EMULATE', true);

include_once 'autoload.php';

$_SERVER['DOCUMENT_ROOT']   = realpath('./resources/joomla');
$_SERVER['SCRIPT_FILENAME'] = realpath('./resources/joomla/index.php');

include_once './resources/joomla/index.php';

