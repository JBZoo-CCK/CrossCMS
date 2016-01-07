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

use JBZoo\CrossCMS\AbstractCache;

/**
 * Class Cache
 * @package JBZoo\CrossCMS
 */
class Cache extends AbstractCache
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return defined('WP_CACHE') && WP_CACHE;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data, $group = self::GROUP_DEFAULT, $isForce = false, $ttl = self::TTL)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'variable');

        return \wp_cache_add($key, $data, $group, $ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $group = self::GROUP_DEFAULT)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'variable');

        return \wp_cache_get($key, $group);
    }

    /**
     * {@inheritdoc}
     */
    public function start($key, $group = self::GROUP_DEFAULT, $isForce = false, $ttl = self::TTL)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'output');

        $result = \wp_cache_get($key, $group, $isForce);
        if ($result) {
            echo $result;
            return true;
        }

        ob_start();
        ob_implicit_flush(false);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function end($key, $group = self::GROUP_DEFAULT)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'output');

        $output = ob_get_contents();
        ob_end_clean();

        \wp_cache_add($key, $output, $group);

        echo $output;
    }

}
