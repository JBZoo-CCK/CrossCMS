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
 * Class AbstractConfig
 * @package JBZoo\CrossCMS
 */
abstract class AbstractConfig
{
    /**
     * @return string
     */
    abstract public function sitename();

    /**
     * @return string
     */
    abstract public function sitedesc();

    /**
     * @return string
     */
    abstract public function email();

    /**
     * @return string
     */
    abstract public function dbHost();

    /**
     * @return string
     */
    abstract public function dbUser();

    /**
     * @return string
     */
    abstract public function dbPass();

    /**
     * @return string
     */
    abstract public function dbName();

    /**
     * @return string
     */
    abstract public function dbPrefix();

    /**
     * @return string
     */
    abstract public function dbType();

    /**
     * @return bool
     */
    abstract public function isDebug();

    /**
     * @return string
     */
    abstract public function timezone();
}
