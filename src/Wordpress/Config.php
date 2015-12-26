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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractConfig;
use JBZoo\Utils\Vars;

/**
 * Class Session
 * @package JBZoo\CrossCMS
 */
class Config extends AbstractConfig
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function sitename()
    {
        return get_option('blogname', '');
    }

    /**
     * {@inheritdoc}
     */
    public function sitedesc()
    {
        return get_option('blogdescription', '');
    }

    /**
     * {@inheritdoc}
     */
    public function email()
    {
        return get_option('admin_email', '');
    }

    /**
     * {@inheritdoc}
     */
    public function dbHost()
    {
        if (defined('DB_HOST')) {
            return DB_HOST;
        }

        return ''; // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    public function dbUser()
    {
        if (defined('DB_USER')) {
            return DB_USER;
        }

        return ''; // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    public function dbPass()
    {
        if (defined('DB_PASSWORD')) {
            return DB_PASSWORD;
        }

        return ''; // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    public function dbName()
    {
        if (defined('DB_NAME')) {
            return DB_NAME;
        }

        return ''; // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function dbPrefix()
    {
        return Vars::get($GLOBALS['table_prefix'], '');
    }

    /**
     * {@inheritdoc}
     */
    public function dbType()
    {
        return 'mysqli'; // lifehack
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        if (defined('WP_DEBUG')) {
            return (bool)WP_DEBUG;
        }

        return ''; // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    public function timezone()
    {
        return get_option('timezone_string', '');
    }
}
