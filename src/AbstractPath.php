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

use JBZoo\Path\Path;

/**
 * Class AbstractPath
 * @package JBZoo\CrossCMS
 */
abstract class AbstractPath
{
    /**
     * @return string
     */
    abstract public function getRoot();

    /**
     * @return string
     */
    abstract public function getUpload();

    /**
     * @return string
     */
    abstract public function getCache();

    /**
     * @return string
     */
    abstract public function getTmpl();

    /**
     * @return string
     */
    abstract public function getTmp();

    /**
     * @return string
     */
    abstract public function getLogs();
}
