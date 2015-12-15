<?php

define('_JEXEC', 1); // We are a valid entry point.
define('JPATH_BASE', CMS_JOOMLA_PATH);

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

JFactory::getApplication('site');
