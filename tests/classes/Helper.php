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

namespace JBZoo\PHPUnit;

use GuzzleHttp\Client;
use JBZoo\CrossCMS\Cms;
use JBZoo\Data\Data;
use JBZoo\Utils\Env;
use JBZoo\Utils\Url;

/**
 * Class Helper
 * @package JBZoo\PHPUnit
 */
class Helper
{
    /**
     * @param $testName
     * @param $request
     * @return Data
     */
    public function request($testName, $request)
    {
        $cms = Cms::getInstance();

        $host = Env::get('TEST_HOST', '127.0.0.1');
        $port = Env::get('TEST_PORT');

        $url = Url::create([
            'host'  => $host,
            'port'  => $port,
            'path'  => '/',
            'query' => array_merge([
                'jbzoo-phpunit'      => 1,
                'jbzoo-phpunit-test' => $this->getTestName($testName),
                'jbzoo-phpunit-type' => strtolower($cms['type'])
            ], $request),
        ]);

        //dump($url, 0);

        $client     = new Client();
        $httpResult = $client->get($url, [
            'allow_redirects' => false,
            'exceptions'      => false,
            'timeout'         => 30,
            'connect_timeout' => 30,
            //'debug'           => true,
            'verify'          => false,
        ]);

        // Prepare headers
        $rawHeaders = $httpResult->getHeaders();
        $headers    = [];
        foreach ($rawHeaders as $key => $value) {
            $key   = strtolower($key);
            $value = implode(' ', $value);

            $headers[$key] = $value;
        }

        // To simple format
        $result = new Data([
            'code'    => $httpResult->getStatusCode(),
            'headers' => $headers,
            'body'    => $httpResult->getBody()->getContents()
        ]);

        return $result;
    }

    /**
     * @param array $data
     * @return string
     */
    public function query(array $data = array())
    {
        $data['jbzoo-phpunit'] = 1;

        return http_build_query($data, null, '&');
    }

    /**
     * @param $testName
     * @return mixed|string
     */
    public function getTestName($testName)
    {
        $testName = str_replace(__NAMESPACE__, '', $testName);
        $testName = preg_replace('#[^a-z0-9]#iu', '-', $testName);
        $testName = preg_replace('#--#iu', '-', $testName);
        $testName = trim($testName, '-');
        $testName = strtolower($testName);

        return $testName;
    }
}