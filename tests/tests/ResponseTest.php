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

/**
 * Class ResponseTest
 * @package JBZoo\PHPUnit
 */
class ResponseTest extends CrossCMSUnit
{
    public function testJson()
    {
        $uniq = uniqid();

        $result = $this->helper->request(__METHOD__, array('test-response-json' => array(
            $uniq => $uniq,
        )));

        isSame([$uniq => $uniq], json_decode($result->body, true));
        isSame(200, $result->code);
        isSame('application/json; charset=utf-8', $result->find('headers.content-type'));
        isSame('no-cache', $result->find('headers.pragma'));
    }

    public function testCode404()
    {
        $result = $this->helper->request(__METHOD__, array('test-response-set404' => 1));
        is(404, $result->code);
    }

    public function testCode500()
    {
        $uniq   = uniqid();
        $result = $this->helper->request(__METHOD__, array('test-response-set500' => $uniq));

        isContain($uniq, $result->body);
        is(500, $result->code);
    }

    public function testRedirect()
    {
        $uniq   = '?' . uniqid() . '=1';
        $result = $this->helper->request(__METHOD__, array('test-response-redirect' => $uniq));

        isSame(303, $result->code);
        isContain($uniq, $result->find('headers.location'));
    }

    public function testText()
    {
        $result = $this->helper->request(__METHOD__, array('test-response-text' => 1));

        isSame(
            'text/plain; charset=utf-8',
            $result->find('headers.content-type')
        );
    }

    public function testNocache()
    {
        $result = $this->helper->request(__METHOD__, array('test-response-nocache' => 1));

        isSame('no-cache', $result->find('headers.pragma'));
        isContain('no-store', $result->find('headers.cache-control'));
        isContain('no-cache', $result->find('headers.cache-control'));
        isContain('must-revalidate', $result->find('headers.cache-control'));
    }
}
