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
 * Class Request
 * @package JBZoo\CrossCMS
 */
abstract class AbstractResponse
{
    /**
     * Send code 404 - Page not found
     * @param string $message
     * @return
     */
    abstract public function set404($message = 'Not Found');

    /**
     * Show fatal error
     * @param string $message
     * @return
     */
    abstract public function set500($message = 'Internal Server Error');

    /**
     * Redirect to some other URL
     * @param string $url
     * @param int    $status
     * @return mixed
     */
    abstract public function redirect($url, $status = 303);

    /**
     * Send JSON for ajax
     * @param array $data
     * @param bool  $result
     */
    abstract public function json(array $data = array(), $result = true);

    /**
     * Send text content type headers
     */
    public function text()
    {
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Send only extention output
     */
    abstract public function raw();

    /**
     * Send only extention output + minimal HTML wrapper (body, meta, etc...)
     */
    abstract public function component();

    /**
     * Add noindex and nofollow meta
     */
    abstract public function noindex();

    /**
     * Set document title
     * @param string $title
     */
    abstract public function setTitle($title);

    /**
     * Add nocache headers
     */
    abstract public function noCache();

    /**
     * Set HTTP header for response
     * @param string $name
     * @param string $value
     */
    abstract public function setHeader($name, $value);

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
     * General nocache headers
     */
    protected function _noCache()
    {
        $this->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->setHeader('Last-Modified', gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $this->setHeader('Expires', gmdate('D, d M Y H:i:s', 0) . ' GMT');
        $this->setHeader('Pragma', 'no-cache');
    }
}
