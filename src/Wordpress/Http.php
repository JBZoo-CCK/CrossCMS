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

use JBZoo\CrossCMS\AbstractHttp;
use JBZoo\Data\Data;

/**
 * Class Http
 * @package JBZoo\CrossCMS
 */
class Http extends AbstractHttp
{
    /**
     * {@inheritdoc}
     */
    protected function _request($url, array $args, Data $options)
    {
        $httpClient = _wp_http_get_object();

        $apiResponse = $httpClient->request($url, array(
            'method'  => $options->get('method'),
            'body'    => $args,
            'headers' => $options->get('headers'),
            'timeout' => $options->get('timeout'),
        ));

        return $apiResponse;
    }

    /**
     * {@inheritdoc}
     */
    protected function _compactResponse($apiResponse)
    {
        if ($apiResponse instanceof \WP_Error) {
            throw new \Exception(implode($apiResponse->get_error_messages()));
        }

        $response = array(
            'code'    => (int)$apiResponse['response']['code'],
            'headers' => array_change_key_case($apiResponse['headers'], CASE_LOWER),
            'body'    => $apiResponse['body'],
        );

        $response = new Data($response);

        return $response;
    }
}
