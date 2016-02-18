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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractSession;

/**
 * Class Session
 * @package JBZoo\CrossCMS
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class Session extends AbstractSession
{
    /**
     * @var string
     */
    private $_namespace = 'jbzoo_wp';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        if (!session_id() && !headers_sent()) {
            session_start(); // @codeCoverageIgnore
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $group = self::GROUP_DFAULT)
    {
        if (!isset($_SESSION[$this->_namespace])) {
            $_SESSION[$this->_namespace] = array();
        }

        if (!isset($_SESSION[$this->_namespace][$group])) {
            $_SESSION[$this->_namespace][$group] = array();
        }

        $_SESSION[$this->_namespace][$group][$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null, $group = self::GROUP_DFAULT)
    {
        if (isset($_SESSION[$this->_namespace][$group][$key])) {
            return $_SESSION[$this->_namespace][$group][$key];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroup($group = self::GROUP_DFAULT, $default = array())
    {
        if (isset($_SESSION[$this->_namespace][$group])) {
            return $_SESSION[$this->_namespace][$group];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function clearGroup($group = self::GROUP_DFAULT)
    {
        if (isset($_SESSION[$this->_namespace][$group])) {
            $_SESSION[$this->_namespace][$group] = null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear($key, $group = self::GROUP_DFAULT)
    {
        $this->set($key, null, $group);
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return wp_create_nonce();
    }
}
