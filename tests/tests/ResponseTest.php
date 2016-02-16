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

namespace JBZoo\PHPUnit;

/**
 * Class ResponseTest
 * @package JBZoo\PHPUnit
 */
class ResponseTest extends PHPUnit
{
    public function testCode404()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-response-set404' => 1));

        isContain('404', $html);
    }

    public function testCode500()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-response-set500' => $uniq));

        isContain($uniq, $html);
    }

    public function testRedirect()
    {
        $uniq = '?' . uniqid() . '=1';
        Helper::runIsolatedCMS(__METHOD__, array('test-response-redirect' => $uniq));
    }

    public function testJson()
    {
        $uniq = uniqid();

        $json = Helper::runIsolatedCMS(__METHOD__, array('test-response-json' => array(
            'message' => 'Error message',
            $uniq     => $uniq,
        )));

        isSame(array(
            "message" => "Error message",
            $uniq     => $uniq,
            "result"  => 1,
        ), json_decode($json, true));
    }

    public function testText()
    {
        Helper::runIsolatedCMS(__METHOD__, array('test-response-text' => 1));
        isTrue(true); // We can't check HTTP-headers on CLI mode
    }

    public function testTitle()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-response-title' => $uniq));

        isContain('<title>' . $uniq . '</title>', $html);
    }

    public function testKeywords()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-response-keywords' => $uniq));

        isLike('#<meta name=[\'\"]keywords[\'\"] content=[\'\"]' . $uniq . '[\'\"]#ius', $html);
    }

    public function testDescription()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-response-description' => $uniq));

        isLike('#<meta name=[\'\"]description[\'\"] content=[\'\"]' . $uniq . '[\'\"]#ius', $html);
    }

    public function testNoindex()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-response-noindex' => 1));

        isContain('noindex', $html);
        isContain('nofollow', $html);
    }

    public function testNocache()
    {
        Helper::runIsolatedCMS(__METHOD__, array('test-response-nocache' => 1));
    }

    public function testRaw()
    {
        Helper::runIsolatedCMS(__METHOD__, array('test-response-raw' => 1));
    }

    public function testComponent()
    {
        Helper::runIsolatedCMS(__METHOD__, array('test-response-component' => 1));
    }

    public function testAddMeta()
    {
        $value = uniqid();
        $html  = Helper::runIsolatedCMS(__METHOD__, array('test-response-addmeta' => array(
            'meta'  => 'somemeta1',
            'value' => $value,
        )));
        isLike('#<meta name=[\'\"]somemeta1[\'\"] content=[\'\"]' . $value . '[\'\"]#ius', $html);

        $value = uniqid();
        $html  = Helper::runIsolatedCMS(__METHOD__, array('test-response-addmeta' => array(
            'meta' => '<meta name=\'somemeta2\' content=\'' . $value . '\' />',
        )));
        isLike('#<meta name=[\'\"]somemeta2[\'\"] content=[\'\"]' . $value . '[\'\"]#ius', $html);
    }
}
