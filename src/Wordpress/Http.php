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
    protected function _request($url, $args, Data $options)
    {
        $httpClient = new \WP_Http();

        $apiResponse = $httpClient->request($url, array(
            'body'        => $args,
            'method'      => $options->get('method'),
            'headers'     => $options->get('headers'),
            'timeout'     => $options->get('timeout'),
            'user-agent'  => $options->get('user_agent'),
            'sslverify'   => $options->get('ssl_verify'),
            'redirection' => 20,
        ));

        if ($options->get('debug') && $apiResponse instanceof \WP_Error) {
            $apiResponse = array(
                'body' => implode($apiResponse->get_error_messages()),
            );
        }

        return $apiResponse;
    }

    /**
     * {@inheritdoc}
     */
    protected function _compactResponse($apiResponse)
    {
        $dataResponse = new Data($apiResponse);

        $response = array(
            'code'    => $dataResponse->find('response.code', 0, 'int'),
            'headers' => array_change_key_case((array)$dataResponse->get('headers', array()), CASE_LOWER),
            'body'    => $dataResponse->get('body'),
        );

        $response = new Data($response);

        return $response;
    }
}
