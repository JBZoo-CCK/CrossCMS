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
 * Class AbstractConfig
 * @package JBZoo\CrossCMS
 */
abstract class AbstractConfig
{
    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    abstract public function get($key, $default = null);
}
