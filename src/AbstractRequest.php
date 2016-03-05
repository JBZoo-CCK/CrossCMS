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

use JBZoo\Data\Data;
use JBZoo\Utils\Filter;
use JBZoo\Utils\Http;
use JBZoo\Utils\Url;
use JBZoo\Utils\Vars;

/**
 * Class AbstractRequest
 * @package JBZoo\CrossCMS
 * @SuppressWarnings(PHPMD.Superglobals)
 */
abstract class AbstractRequest extends AbstractHelper
{
    /**
     * Get variable from HTTP headers
     *
     * @param string          $name
     * @param mixed           $default
     * @param string|\Closure $filters
     * @return mixed
     */
    public function getHeader($name, $default = null, $filters = null)
    {
        $value = $this->_header($name, $default);

        if ($filters) {
            $value = Filter::_($value, $filters);
        }

        return $value;
    }

    /**
     * Get variable from request
     *
     * @param string          $name
     * @param mixed           $default
     * @param string|\Closure $filters
     * @return mixed
     */
    public function get($name, $default = null, $filters = null)
    {
        $value = $this->_get($name, $default);

        if ($filters) {
            $value = Filter::_($value, $filters);
        }

        return $value;
    }

    /**
     * Set value into request variable
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $_REQUEST[$name] = $value;

        $method = $this->getMethod();
        if ('POST' === $method) {
            $_POST[$name] = $value;
        } elseif ('GET' === $method) {
            $_GET[$name] = $value;
        }

        $this->_set($name, $value);
    }

    /**
     * Gets the request method.
     * @return  string
     */
    public function getMethod()
    {
        $method = Vars::get($_SERVER['REQUEST_METHOD'], '');
        $method = $this->getHeader('X-HTTP-Method-Override', $method);
        $method = strtoupper($method);

        return $method;
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return 'GET' === $this->getMethod();
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return 'POST' === $this->getMethod();
    }

    /**
     * Is current request - ajax
     * @return bool
     */
    public function isAjax()
    {
        $method = Vars::get($_SERVER['HTTP_X_REQUESTED_WITH'], '');
        $method = Filter::cmd($method);
        $orig   = Filter::cmd('XMLHttpRequestt');

        return $orig === $method;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return Url::current();
    }

    /**
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    protected function _header($name, $default = null)
    {
        static $headers;

        if (is_null($headers)) {
            $headers = Http::getHeaders();
            $headers = new Data($headers);
        }

        $name = strtoupper($name);
        $name = str_replace('-', '_', $name);

        return $headers->get($name, $default);
    }

    /**
     * @param string $name
     * @param mixed  $default
     * @return mixed
     * @internal param bool $isRaw
     */
    abstract protected function _get($name, $default = null);

    /**
     * @param string $name
     * @param mixed  $value
     */
    abstract protected function _set($name, $value);

    /**
     * Get session token for csrf security
     *
     * @param string $name
     * @return string
     */
    abstract public function checkToken($name = 'crosscms');
}
