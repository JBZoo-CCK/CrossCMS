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

use JBZoo\CrossCMS\Exception\Exception;
use JBZoo\Data\Data;
use JBZoo\Utils\Arr;
use JBZoo\Utils\Str;
use JBZoo\Utils\Url;

/**
 * Class AbstractHttp
 * @package JBZoo\CrossCMS
 */
abstract class AbstractHttp
{
    const METHOD_GET     = 'GET';
    const METHOD_POST    = 'POST';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_PUT     = 'PUT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_PATCH   = 'PATCH';

    const RESPONSE_BODY = 'body';
    const RESPONSE_HEAD = 'head';
    const RESPONSE_CODE = 'code';
    const RESPONSE_FULL = 'full';

    const CACHE_GROUP = 'crosscms_http';

    /**
     * @type array
     */
    protected $_defaultOptions = array(
        'timeout'    => 5,
        'method'     => self::METHOD_GET,
        'headers'    => array(),
        'response'   => self::RESPONSE_BODY,
        'cache'      => 0,
        'cache_ttl'  => 60, // in minutes!
        'user_agent' => 'CrossCMS HTTP Client v1.x-dev',
        'debug'      => 0,
    );

    /**
     * Request to external url via CMS API
     *
     * @param string $url
     * @param array  $args
     * @param Data   $options
     * @return mixed
     * @throws \Exception
     */
    abstract protected function _request($url, array $args, Data $options);

    /**
     * @param mixed $apiResponse
     * @return Data
     * @throws \Exception
     */
    abstract protected function _compactResponse($apiResponse);

    /**
     * {@inheritdoc}
     */
    public function request($url, array $args = array(), array $options = array())
    {
        $result = null;

        // Merge with default
        $options = array_merge($this->_defaultOptions, (array)$options);
        $options = new Data($options);

        // Prepare options for request
        $args       = (array)$args;
        $timeout    = (int)$options->get('timeout');
        $headers    = (array)$options->get('headers');
        $userAgent  = trim($options->get('user_agent'));
        $resultType = Str::clean($options->get('response'), true);

        // Prepare options for cache
        $isCache  = (int)$options->get('cache');
        $cacheTTL = (int)$options->get('cache_ttl');
        $cacheId  = array('url' => $url, 'data' => $args, 'options' => $options->getArrayCopy());

        try {
            $method = $this->_getMethod($options->get('method'));

            // Check cache
            if ($isCache && $result = Cms::_('cache')->get($cacheId, self::CACHE_GROUP)) {
                return $result;
            }

            // Add args to url for GET methods
            if (self::METHOD_GET === $method) {
                $url  = Url::addArg($args, $url);
                $args = array();
            }

            // Request via CMS API
            $apiResp = $this->_request($url, $args, new Data(array(
                'timeout'    => $timeout,
                'headers'    => $headers,
                'method'     => $method,
                'user_agent' => $userAgent,
            )));

        } catch (\Exception $e) {

            $body = null;
            if ((int)$options->get('debug')) {
                $body = 'CrossCMS Error: ' . $e->getMessage();
            }

            $apiResp = new Data(array(
                'body'    => $body,
                'headers' => array(),
                'code'    => 0,
            ));
        }

        // Prepare response format
        $response = $this->_compactResponse($apiResp);
        $result   = $this->_getResultByType($response, $resultType);

        // Store to cache
        if ($isCache && null !== $result) {
            Cms::_('cache')->set($cacheId, $result, self::CACHE_GROUP, true, $cacheTTL);
        }

        return $result;
    }

    /**
     * @param Data   $response
     * @param string $resultType
     * @return mixed
     */
    protected function _getResultByType(Data $response, $resultType)
    {
        // response type
        if ($resultType == self::RESPONSE_BODY && 200 === $response->get('code')) {
            $result = $response->get('body');

        } elseif ($resultType == self::RESPONSE_HEAD) {
            $result = new Data($response->get('headers'));

        } elseif ($resultType == self::RESPONSE_CODE) {
            $result = $response->get('code');

        } elseif ($resultType == self::RESPONSE_FULL) {
            $result = $response;

        } else {
            $result = $response->get('body');
        }

        return $result;
    }

    /**
     * Clean and validate HTTP-method type
     *
     * @param string $method
     * @return string
     * @throws Exception
     */
    protected function _getMethod($method)
    {
        $method = trim(Str::up($method));

        $validList = array(
            self::METHOD_GET,
            self::METHOD_POST,
            self::METHOD_HEAD,
            self::METHOD_PUT,
            self::METHOD_DELETE,
            self::METHOD_OPTIONS,
            self::METHOD_PATCH,
        );

        if (Arr::in($method, $validList)) {
            return $method;
        } else {
            throw new Exception('Unsupported Request Method: ' . $method);
        }
    }
}
