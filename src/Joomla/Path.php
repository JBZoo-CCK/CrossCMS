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

namespace JBZoo\CrossCMS\Joomla;

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
        return JPATH_ROOT;
    }

    /**
     * @return string
     */
    public function getUpload()
    {
        $params = \JComponentHelper::getParams('com_media');
        $path   = JPATH_ROOT . '/' . $params->get('image_path', 'images');

        if ($path = realpath($path)) {
            return $path;
        }

        return $this->getRoot() . DIRECTORY_SEPARATOR . 'images'; // @codeCoverageIgnore
    }

    /**
     * @return string
     */
    public function getCache()
    {
        return JPATH_CACHE;
    }

    /**
     * @return string
     */
    public function getTmpl()
    {
        return JPATH_THEMES;
    }

    /**
     * @return string
     */
    public function getTmp()
    {
        $tmpPath = \JFactory::getConfig()->get('tmp_path');

        if ($tmpPath = realpath($tmpPath)) {
            return $tmpPath;
        }

        return $this->getRoot() . DIRECTORY_SEPARATOR . 'tmp'; // @codeCoverageIgnore
    }

    /**
     * @return string
     */
    public function getLogs()
    {
        $tmpPath = \JFactory::getConfig()->get('log_path');

        if ($tmpPath = realpath($tmpPath)) {
            return $tmpPath;
        }

        return $this->getRoot() . DIRECTORY_SEPARATOR . 'logs'; // @codeCoverageIgnore
    }
}
