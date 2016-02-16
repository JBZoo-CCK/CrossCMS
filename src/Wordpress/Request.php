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

use JBZoo\CrossCMS\AbstractRequest;

/**
 * Class Request
 * @package JBZoo\CrossCMS
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class Request extends AbstractRequest
{
    /**
     * @var \WP_Query
     */
    private $_wp_query = null;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->_wp_query = $GLOBALS['wp_query'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _get($name, $default = null)
    {
        return $this->_wp_query->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    protected function _set($name, $value)
    {
        $this->_wp_query->set($name, $value);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function checkToken($name = 'crosscms')
    {
        return wp_verify_nonce($name);
    }
}
