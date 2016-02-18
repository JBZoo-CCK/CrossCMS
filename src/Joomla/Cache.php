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

namespace JBZoo\CrossCMS\Joomla;

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
        return (int)\JFactory::getConfig()->get('caching', 0);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data, $group = self::GROUP_DEFAULT, $isForce = false, $ttl = self::TTL)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'variable');
        $cache = \JFactory::getCache($group, 'output');

        if ($isForce) {
            $cache->setCaching(true);
        }

        if ((int)$ttl > 0) {
            $cache->setLifeTime((int)$ttl);
        }

        return $cache->store($data, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $group = self::GROUP_DEFAULT)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'variable');
        $cache = \JFactory::getCache($group, 'output');

        return $cache->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function start($key, $group = self::GROUP_DEFAULT, $isForce = false, $ttl = self::TTL)
    {
        $key   = $this->hash($key);
        $group = $this->_cleanGroup($group, 'output');
        $cache = \JFactory::getCache($group, 'output');

        if ($isForce) {
            $cache->setCaching(true);
        }

        $ttl = (int)$ttl;
        if ($ttl > 0) {
            $cache->setLifeTime($ttl);
        }

        $result = $cache->get($key);
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
        $cache = \JFactory::getCache($group, 'output');

        $output = ob_get_contents();
        ob_end_clean();

        $cache->store($output, $key);

        echo $output;
    }
}
