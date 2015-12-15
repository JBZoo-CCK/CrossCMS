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

namespace JBZoo\CrossCMS;

/**
 * Class AbstractSession
 * @package JBZoo\CrossCMS
 */
abstract class AbstractSession
{
    const GROUP_DFAULT = 'jbzoo';

    /**
     * @param  string $key
     * @return bool
     */
    public function has($key)
    {
        $value = $this->get($key);
        return null !== $value;
    }

    /**
     * @param  string $key
     * @param  mixed  $default
     * @param  string $group
     * @return mixed
     */
    abstract public function get($key, $default = null, $group = self::GROUP_DFAULT);

    /**
     * @param string $key
     * @param mixed  $value
     * @param string $group
     */
    abstract public function set($key, $value, $group = self::GROUP_DFAULT);

    /**
     * @param string $group
     * @param array  $default
     * @return array
     */
    abstract public function getGroup($group = self::GROUP_DFAULT, $default = array());

    /**
     * @param array  $data
     * @param string $group
     * @param bool   $isFullReplace
     */
    abstract public function setGroup($group = self::GROUP_DFAULT, array $data = array(), $isFullReplace = true);

    /**
     * @param string $key
     * @param string $group
     */
    abstract public function clear($key, $group = self::GROUP_DFAULT);

    /**
     * @param string $group
     */
    abstract public function clearGroup($group = self::GROUP_DFAULT);

    /**
     * @return string
     */
    abstract public function getToken();

}