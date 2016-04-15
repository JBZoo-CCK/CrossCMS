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

use JBZoo\Utils\Cli;

/**
 * Class AbstractSession
 * @package JBZoo\CrossCMS
 */
abstract class AbstractEnv extends AbstractHelper
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
     * @return string
     */
    abstract public function getRootUrl();

    /**
     * @return bool
     */
    public function isCli()
    {
        return Cli::check();
    }
}
