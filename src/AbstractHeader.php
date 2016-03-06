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
     * Set document title
     * @param string $title
     */
    abstract public function setTitle($title);

    /**
     * Set document description
     * @param string $description
     */
    abstract public function setDesc($description);

    /**
     * Set document keywords
     * @param string $keywords
     */
    abstract public function setKeywords($keywords);

    /**
     * Set document metadata
     * @param string      $meta
     * @param string|null $value
     * @return mixed
     */
    abstract public function addMeta($meta, $value = null);

    /**
     * Add noindex and nofollow meta
     */
    abstract public function noindex();

    /**
     * @param string $file
     * @return bool
     */
    abstract public function jsFile($file);

    /**
     * @param string $file
     * @return bool
     */
    abstract public function cssFile($file);

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
