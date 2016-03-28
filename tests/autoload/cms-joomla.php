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

define('_JEXEC', 1); // We are a valid entry point.
define('JPATH_BASE', CMS_PATH_JOOMLA);

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

JFactory::getApplication('site');
