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
 * Class AbstractHeader
 * @package JBZoo\CrossCMS
 */
abstract class AbstractHeader extends AbstractHelper
{
    /**
     * @param string $file
     * @return bool
     */
    abstract public function cssFile($file);

    /**
     * @param string $file
     * @return bool
     */
    abstract public function jsFile($file);

    /**
     * @param string $code
     * @return bool
     */
    abstract public function jsCode($code);

    /**
     * @param string $code
     * @return bool
     */
    abstract public function cssCode($code);
}