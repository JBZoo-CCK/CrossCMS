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

use JBZoo\CrossCMS\AbstractHttp;
use JBZoo\Data\JSON;

/**
 * Class HttpTest
 * @package JBZoo\PHPUnit
 */
class HttpTest extends CrossCMS
{
    protected $_url = 'http://www.mocky.io/v2/5773641a0f0000f104597a4e';

    protected function setUp()
    {
        parent::setUp();
        sleep(1); // timeout for mockbin.org
    }

    /* Simple *********************************************************************************************************/

    public function testSimple_request()
    {
        $resp = $this->_cms['http']->request($this->_url, array('qwerty' => '123456'));
        isSame('{"key":"value"}', $resp->body);
    }

    public function testSimple_https()
    {
        $resp = $this->_cms['http']->request('https://mockbin.org/gzip', array(), array(
            'debug'      => 1,
            'ssl_verify' => 0, // For travis ... =(
        ));

        if ('"Hello World!"' === $resp) {
            isSame('"Hello World!"', $resp);

            $resp = $this->_cms['http']->request('https://mockbin.org/request', array(), array(
                'debug'      => 1,
                'ssl_verify' => 0, // For travis ... =(
            ));
            $data = new JSON($resp);
            isSame('https://mockbin.org/request', $data->get('url'));

        } else {
            cliMessage('CrossCMS SSL Error: ' . $resp);
        }
    }

    public function testSimple_POSTpayload()
    {
        $payload = json_encode(array('key' => 'value'));

        $resp = $this->_cms['http']->request('http://mockbin.org/request', $payload, array(
            'method'     => 'POST',
            'debug'      => 1,
            'ssl_verify' => 0, // For travis ... =(
        ));

        $data = new JSON($resp->body);

        isSame($payload, $data->find('postData.text'));
    }

    public function testSimple_404()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/code/404', array(), array(
            'response' => AbstractHttp::RESULT_CODE,
        ));
        isSame(404, $resp);
    }

    public function testSimple_gzip()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/gzip', array());
        isSame('"Hello World!"', $resp->body);
    }

    /* Methods ********************************************************************************************************/

    public function testMethod_GET()
    {
        $uniq = uniqid();
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array('qwerty' => $uniq));

        $data = new JSON($resp->body);

        isSame('GET', $data->get('method'));
        isSame($uniq, $data->find('queryString.qwerty'));
        isSame('http://mockbin.org/request?qwerty=' . $uniq, $data->get('url'));

        $uniq = uniqid();
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array('qwerty' => $uniq), array(
            'method' => AbstractHttp::METHOD_GET,
        ));

        $data = new JSON($resp->body);

        isSame('GET', $data->get('method'));
        isSame($uniq, $data->find('queryString.qwerty'));
        isSame('http://mockbin.org/request?qwerty=' . $uniq, $data->get('url'));
    }

    public function testMethod_POST()
    {
        $uniq = uniqid();
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array('qwerty' => $uniq), array(
            'method' => AbstractHttp::METHOD_POST,
        ));

        $data = new JSON($resp->body);

        isSame('POST', $data->get('method'));
        isSame($uniq, $data->find('postData.params.qwerty'));
        isSame('http://mockbin.org/request', $data->get('url'));
    }

    public function testMethod_HEAD()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array(), array(
            'method'   => AbstractHttp::METHOD_HEAD,
            'response' => AbstractHttp::RESULT_FULL,
        ));

        isSame('HEAD', $resp->find('headers.access-control-allow-methods'));
    }

    public function testMethod_PUT()
    {
        $uniq = uniqid();
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array('qwerty' => $uniq), array(
            'method' => AbstractHttp::METHOD_PUT,
        ));

        $data = new JSON($resp->body);

        isSame('PUT', $data->get('method'));
        isSame($uniq, $data->find('postData.params.qwerty'));
    }

    public function testMethod_DELETE()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array(), array(
            'method' => AbstractHttp::METHOD_DELETE,
        ));

        $data = new JSON($resp->body);

        isSame('DELETE', $data->get('method'));
    }

    public function testMethod_OPTIONS()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array(), array(
            'method' => AbstractHttp::METHOD_OPTIONS,
        ));

        $data = new JSON($resp->body);

        isSame('OPTIONS', $data->get('method'));
    }

    public function testMethod_PATCH()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/request', array(), array(
            'method' => AbstractHttp::METHOD_PATCH,
        ));

        $data = new JSON($resp->body);

        isSame('PATCH', $data->get('method'));
    }

    /* Result *********************************************************************************************************/

    public function testResult_code()
    {
        $resp = $this->_cms['http']->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_CODE,
        ));

        isSame(200, $resp);
    }

    public function testResult_headers()
    {
        $resp = $this->_cms['http']->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_HEAD,
        ));

        isSame('foo', $resp->get('x-custom-header'));
        isSame('bar', $resp->get('x-custom-header-2'));
    }

    public function testResult_body()
    {
        $resp = $this->_cms['http']->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_BODY,
        ));

        isSame('{"key":"value"}', $resp);
    }

    public function testResult_full()
    {
        $resp = $this->_cms['http']->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_FULL,
        ));

        $data = new JSON($resp);

        isSame('{"key":"value"}', $data->get('body'));
        isSame('foo', $data->find('headers.x-custom-header'));
        isSame(200, $data->find('code'));
    }

    /* Options ********************************************************************************************************/

    public function testOption_cache()
    {
        $uniq = uniqid();
        $args = array('qwerty' => $uniq);

        $respBefore = $this->_cms['http']->request('http://mockbin.org/request', $args, array('cache' => true));
        sleep(1);
        $respAfter = $this->_cms['http']->request('http://mockbin.org/request', $args, array('cache' => true));

        $dataBefore = new JSON($respBefore);
        $dataAfter  = new JSON($respAfter);

        isSame($dataBefore->get('starteddatetime'), $dataAfter->get('starteddatetime'));
    }

    public function testOption_timeout()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/delay/5001', array(), array(
            'timeout' => 2,
        ));
        is(0, $resp->code);

        $resp = $this->_cms['http']->request('http://mockbin.org/delay/5002', array(), array(
            'timeout' => 10,
        ));

        $data = new JSON($resp->body);
        isSame(5002, $data->get('delay'));
    }

    public function testOption_userAgent()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/agent');
        isSame('"CrossCMS HTTP Client v1.x-dev"', $resp->body);

        $uniq = uniqid();
        $resp = $this->_cms['http']->request('http://mockbin.org/agent', array(), array(
            'user_agent' => ' Custom name' . $uniq . ' ',
        ));

        isSame('"Custom name' . $uniq . '"', $resp->body);
    }

    /* Redirects ******************************************************************************************************/

    public function testRedirect_simple()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/redirect/303', array());
        isSame('"redirect finished"', $resp->body);
    }

    public function testRedirect_toUrl()
    {
        $resp = $this->_cms['http']->request('http://mockbin.org/redirect/303', array('to' => 'http://mockbin.org/gzip'));
        isSame('"Hello World!"', $resp->body);
    }

    public function testRedirect_loop()
    {
        $args = array('to' => 'http://mockbin.org/gzip');
        $resp = $this->_cms['http']->request('http://mockbin.org/redirect/308/10', $args);
        isSame('"Hello World!"', $resp->body);
    }

    /* Other **********************************************************************************************************/

    public function testSend_headers()
    {
        $uniq     = uniqid();
        $resp     = $this->_cms['http']->request('http://mockbin.org/headers', array(), array(
            'headers' => array(
                'x-custom-header' => $uniq,
            ),
        ));
        $data     = new JSON($resp->body);
        $dataFlat = $data->flattenRecursive();

        isTrue(in_array('x-custom-header', $dataFlat, true));
        isTrue(in_array($uniq, $dataFlat, true));
    }
}
