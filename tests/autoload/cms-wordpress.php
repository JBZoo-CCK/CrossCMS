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

define('ABSPATH', CMS_PATH_WORDPRESS . DS);

define('WP_USE_EXT_MYSQL', false);
define('WP_DEBUG_DISPLAY', true);
define('WP_INSTALLING', true);
define('SAVEQUERIES', false);
define('WP_CACHE', false);

define('WP_TESTS_TABLE_PREFIX', false);
define('WP_TESTS_FORCE_KNOWN_BUGS', false);
define('DISABLE_WP_CRON', true);
define('WP_MEMORY_LIMIT', -1);
define('WP_MAX_MEMORY_LIMIT', -1);
define('WP_TESTS_DOMAIN', 'domain.com');

/*
 * Globalize some WordPress variables, because PHPUnit loads this file inside a function
 * See: https://github.com/sebastianbergmann/phpunit/issues/325
 */
global $wpdb, $current_site, $current_blog, $wp_rewrite, $shortcode_tags, $wp, $phpmailer;

// For adding hooks before loading WP
function tests_add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
{
    global $wp_filter, $merged_filters;

    $idx = _test_filter_build_unique_id($tag, $function_to_add, $priority);

    $wp_filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
    unset($merged_filters[$tag]);

    return true;
}

function _test_filter_build_unique_id($tag, $function, $priority)
{
    global $wp_filter;
    static $filter_id_count = 0;

    if (is_string($function))
        return $function;

    if (is_object($function)) {
        $function = array($function, '');
    } else {
        $function = (array)$function;
    }

    if (is_object($function[0])) {
        return spl_object_hash($function[0]) . $function[1];
    } else if (is_string($function[0])) {
        return $function[0] . $function[1];
    }
}

// Allow tests to override wp_die
$GLOBALS['_wp_die_disabled'] = false;
tests_add_filter('wp_die_handler', '_wp_die_handler_filter');

require_once realpath(ABSPATH . 'wp-config.php');
