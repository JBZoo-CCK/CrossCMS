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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractPath;

/**
 * Class Path
 * @package JBZoo\CrossCMS
 */
class Path extends AbstractPath
{
    /**
     * @return string
     */
    public function getRoot()
    {
        return ABSPATH;
    }

    /**
     * @return string
     */
    public function getUpload()
    {
        $paths = wp_upload_dir();
        return $paths['basedir'];
    }

    /**
     * @return string
     */
    public function getCache()
    {
        return $this->getRoot() . '/cache';
    }

    /**
     * @return string
     */
    public function getTmpl()
    {
        return WP_CONTENT_DIR . '/' . get_theme_roots();
    }

    /**
     * @return string
     */
    public function getTmp()
    {
        return $this->getRoot() . '/tmp';
    }

    /**
     * @return string
     */
    public function getLogs()
    {
        return $this->getRoot() . '/logs';
    }
}
