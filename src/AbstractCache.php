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

namespace JBZoo\CrossCMS;

/**
 * Class AbstractCache
 * @package JBZoo\CrossCMS
 */
abstract class AbstractCache
{
    const GROUP_PREFIX  = 'crosscms';
    const GROUP_DEFAULT = 'default';

    const TTL = 86400;

    /**
     * @return bool
     */
    abstract public function isEnabled();

    /**
     * @param string $key
     * @param mixed  $data
     * @param string $group
     * @param bool   $isForce
     * @param int    $ttl
     * @return mixed
     */
    abstract public function set($key, $data, $group = self::GROUP_DEFAULT, $isForce = false, $ttl = self::TTL);

    /**
     * @param string $key
     * @param string $group
     * @return mixed
     */
    abstract public function get($key, $group = self::GROUP_DEFAULT);

    /**
     * @param string $key
     * @param string $group
     * @param bool   $isForce
     * @param int    $ttl
     * @return mixed
     */
    abstract public function start($key, $group = self::GROUP_DEFAULT, $isForce = false, $ttl = self::TTL);

    /**
     * @param string $key
     * @param string $group
     * @return mixed
     */
    abstract public function end($key, $group = self::GROUP_DEFAULT);

    /**
     * Create simple hash from var
     * @param mixed $var
     * @return string
     */
    public function hash($var)
    {
        return md5(serialize($var));
    }

    /**
     * Create simple hash from var
     * @param string $group
     * @param string $type
     * @return string
     */
    protected function _cleanGroup($group, $type)
    {
        return self::GROUP_PREFIX . '_' . md5($group . '||' . $type);
    }
}
