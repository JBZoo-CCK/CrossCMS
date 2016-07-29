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
class ResponseTest extends CrossCMS
{
    public function testCode404()
    {
        skip();

        $html = $this->helper->runIsolatedCMS(__METHOD__, array('test-response-set404' => 1));

        isContain('404', $html);
    }

    public function testCode500()
    {
        skip();

        $uniq = uniqid();
        $html = $this->helper->runIsolatedCMS(__METHOD__, array('test-response-set500' => $uniq));

        isContain($uniq, $html);
    }

    public function testRedirect()
    {
        $uniq = '?' . uniqid() . '=1';
        $this->helper->runIsolatedCMS(__METHOD__, array('test-response-redirect' => $uniq));
    }

    public function testJson()
    {
        skip();
        $uniq = uniqid();

        $json = $this->helper->runIsolatedCMS(__METHOD__, array('test-response-json' => array(
            //'message' => 'Error message',
            $uniq => $uniq,
        )));

        isSame(array(
            //"message" => "Error message",
            $uniq => $uniq,
            //"result"  => 1,
        ), json_decode($json, true));
    }

    public function testText()
    {
        $this->helper->runIsolatedCMS(__METHOD__, array('test-response-text' => 1));
        isTrue(true); // We can't check HTTP-headers on CLI mode
    }

    public function testNocache()
    {
        $this->helper->runIsolatedCMS(__METHOD__, array('test-response-nocache' => 1));
    }

    public function testRaw()
    {
        $this->helper->runIsolatedCMS(__METHOD__, array('test-response-raw' => 1));
    }

    public function testComponent()
    {
        $this->helper->runIsolatedCMS(__METHOD__, array('test-response-component' => 1));
    }
}
