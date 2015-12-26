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
abstract class AbstractEnv
{
    /**
     * @return string
     */
    abstract public function getVersion();

    /**
     * @return bool
     */
    abstract public function isSite();

    /**
     * @return bool
     */
    abstract public function isAdmin();

    /**
     * @return bool
     */
    public function isCli()
    {
        return PHP_SAPI === 'cli' && defined('STDOUT');
    }
}
