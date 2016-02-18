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
use JBZoo\CrossCMS\Cms;
use JBZoo\Data\JSON;

/**
 * Class HttpTest
 * @package JBZoo\PHPUnit
 */
class HttpTest extends PHPUnit
{

    protected $_url = 'http://mockbin.org/bin/28cbba67-c8f3-42f2-bc4d-5610f044e913';

    /* Simple *********************************************************************************************************/

    public function testSimple_request()
    {
        $resp = Cms::_('http')->request($this->_url, array('qwerty' => '123456'));
        isSame('{"key":"value"}', $resp);
    }

    public function testSimple_https()
    {
        $resp = Cms::_('http')->request('https://mockbin.org/gzip', array(), array(
            'debug'      => 1,
            'ssl_verify' => 0, // For travis ... =(
        ));
        isSame('"Hello World!"', $resp, 'SSL Error:' . $resp);


        $resp = Cms::_('http')->request('https://mockbin.org/request', array(), array(
            'debug'      => 1,
            'ssl_verify' => 0, // For travis ... =(
        ));
        $data = new JSON($resp);
        isSame('https://mockbin.org/request', $data->get('url'), 'SSL Error:' . $resp);
    }

    public function testSimple_404()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/code/404', array(), array(
            'response' => AbstractHttp::RESULT_CODE,
        ));
        isSame(404, $resp);
    }

    public function testSimple_gzip()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/gzip', array());
        isSame('"Hello World!"', $resp);
    }

    /* Methods ********************************************************************************************************/

    public function testMethod_GET()
    {
        $uniq = uniqid();
        $resp = Cms::_('http')->request('http://mockbin.org/request', array('qwerty' => $uniq));

        $data = new JSON($resp);

        isSame('GET', $data->get('method'));
        isSame($uniq, $data->find('queryString.qwerty'));
        isSame('http://mockbin.org/request?qwerty=' . $uniq, $data->get('url'));

        $uniq = uniqid();
        $resp = Cms::_('http')->request('http://mockbin.org/request', array('qwerty' => $uniq), array(
            'method' => AbstractHttp::METHOD_GET,
        ));

        $data = new JSON($resp);

        isSame('GET', $data->get('method'));
        isSame($uniq, $data->find('queryString.qwerty'));
        isSame('http://mockbin.org/request?qwerty=' . $uniq, $data->get('url'));
    }

    public function testMethod_POST()
    {
        $uniq = uniqid();
        $resp = Cms::_('http')->request('http://mockbin.org/request', array('qwerty' => $uniq), array(
            'method' => AbstractHttp::METHOD_POST,
        ));

        $data = new JSON($resp);

        isSame('POST', $data->get('method'));
        isSame($uniq, $data->find('postData.params.qwerty'));
        isSame('http://mockbin.org/request', $data->get('url'));
    }

    public function testMethod_HEAD()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/request', array(), array(
            'method'   => AbstractHttp::METHOD_HEAD,
            'response' => AbstractHttp::RESULT_FULL,
        ));

        isSame('HEAD', $resp->find('headers.access-control-allow-methods'));
    }

    public function testMethod_PUT()
    {
        $uniq = uniqid();
        $resp = Cms::_('http')->request('http://mockbin.org/request', array('qwerty' => $uniq), array(
            'method' => AbstractHttp::METHOD_PUT,
        ));

        $data = new JSON($resp);

        isSame('PUT', $data->get('method'));
        isSame($uniq, $data->find('postData.params.qwerty'));
    }

    public function testMethod_DELETE()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/request', array(), array(
            'method' => AbstractHttp::METHOD_DELETE,
        ));

        $data = new JSON($resp);

        isSame('DELETE', $data->get('method'));
    }

    public function testMethod_OPTIONS()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/request', array(), array(
            'method' => AbstractHttp::METHOD_OPTIONS,
        ));

        $data = new JSON($resp);

        isSame('OPTIONS', $data->get('method'));
    }

    public function testMethod_PATCH()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/request', array(), array(
            'method' => AbstractHttp::METHOD_PATCH,
        ));

        $data = new JSON($resp);

        isSame('PATCH', $data->get('method'));
    }

    public function testSend_headers()
    {
        $uniq     = uniqid();
        $resp     = Cms::_('http')->request('http://mockbin.org/headers', array(), array(
            'headers' => array(
                'x-custom-header' => $uniq,
            ),
        ));
        $data     = new JSON($resp);
        $dataFlat = $data->flattenRecursive();

        isTrue(in_array('x-custom-header', $dataFlat, true));
        isTrue(in_array($uniq, $dataFlat, true));
    }

    public function testResult_code()
    {
        $resp = Cms::_('http')->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_CODE,
        ));

        isSame(200, $resp);
    }

    public function testResult_headers()
    {
        $resp = Cms::_('http')->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_HEAD,
        ));

        isSame('foo', $resp->get('x-custom-header'));
        isSame('bar', $resp->get('x-custom-header-2'));
    }

    public function testResult_body()
    {
        $resp = Cms::_('http')->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_BODY,
        ));

        isSame('{"key":"value"}', $resp);
    }

    public function testResult_full()
    {
        $resp = Cms::_('http')->request($this->_url, array(), array(
            'response' => AbstractHttp::RESULT_FULL,
        ));

        $data = new JSON($resp);

        isSame('{"key":"value"}', $data->get('body'));
        isSame('foo', $data->find('headers.x-custom-header'));
        isSame(200, $data->find('code'));
    }

    public function testOption_cache()
    {
        $uniq = uniqid();
        $args = array('qwerty' => $uniq);

        $respBefore = Cms::_('http')->request('http://mockbin.org/request', $args, array('cache' => true));
        sleep(1);
        $respAfter = Cms::_('http')->request('http://mockbin.org/request', $args, array('cache' => true));

        $dataBefore = new JSON($respBefore);
        $dataAfter  = new JSON($respAfter);

        isSame($dataBefore->get('starteddatetime'), $dataAfter->get('starteddatetime'));
    }

    public function testOption_timeout()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/delay/5001', array(), array(
            'timeout' => 2,
        ));
        isNull($resp);

        $resp = Cms::_('http')->request('http://mockbin.org/delay/5002', array(), array(
            'timeout' => 10,
        ));

        $data = new JSON($resp);
        isSame(5002, $data->get('delay'));
    }

    public function testOption_userAgent()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/agent');
        isSame('"CrossCMS HTTP Client v1.x-dev"', $resp);

        $uniq = uniqid();
        $resp = Cms::_('http')->request('http://mockbin.org/agent', array(), array(
            'user_agent' => ' Custom name' . $uniq . ' ',
        ));

        isSame('"Custom name' . $uniq . '"', $resp);
    }

    public function testOption_debug()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/request', array(), array(
            'response' => AbstractHttp::RESULT_FULL,
            'method'   => 'undefined',
            'debug'    => 0,
        ));

        isNull($resp->get('body'));
        //isFalse($resp->get('info'));

        $resp = Cms::_('http')->request('http://mockbin.org/request', array(), array(
            'response' => AbstractHttp::RESULT_FULL,
            'method'   => 'undefined',
            'debug'    => 1,
        ));

        isContain('CrossCMS Error: ', $resp->get('body'));
        //isTrue($resp->get('info')); // TODO Add extended debug information (trace, times, memory, etc)
    }

    public function testRedirect_simple()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/redirect/303', array());
        isSame('"redirect finished"', $resp);
    }

    public function testRedirect_toUrl()
    {
        $resp = Cms::_('http')->request('http://mockbin.org/redirect/303', array('to' => 'http://mockbin.org/gzip'));
        isSame('"Hello World!"', $resp);
    }

    public function testRedirect_loop()
    {
        $args = array('to' => 'http://mockbin.org/gzip');
        $resp = Cms::_('http')->request('http://mockbin.org/redirect/308/10', $args);
        isSame('"Hello World!"', $resp);
    }
}
