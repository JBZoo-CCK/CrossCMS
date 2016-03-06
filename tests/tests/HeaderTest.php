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
 * Class HeaderTest
 * @package JBZoo\PHPUnit
 */
class HeaderTest extends CrossCMS
{
    public function testTitle()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-title' => $uniq));

        isContain('<title>' . $uniq . '</title>', $html);
    }

    public function testKeywords()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-keywords' => $uniq));

        isLike('#<meta name=[\'\"]keywords[\'\"] content=[\'\"]' . $uniq . '[\'\"]#ius', $html);
    }

    public function testDescription()
    {
        $uniq = uniqid();
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-description' => $uniq));

        isLike('#<meta name=[\'\"]description[\'\"] content=[\'\"]' . $uniq . '[\'\"]#ius', $html);
    }

    public function testNoindex()
    {
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-noindex' => 1));

        isContain('noindex', $html);
        isContain('nofollow', $html);
    }

    public function testAddMeta()
    {
        $value = uniqid();
        $html  = Helper::runIsolatedCMS(__METHOD__, array('test-header-addmeta' => array(
            'meta'  => 'somemeta1',
            'value' => $value,
        )));
        isLike('#<meta name=[\'\"]somemeta1[\'\"] content=[\'\"]' . $value . '[\'\"]#ius', $html);

        $value = uniqid();
        $html  = Helper::runIsolatedCMS(__METHOD__, array('test-header-addmeta' => array(
            'meta' => '<meta name=\'somemeta2\' content=\'' . $value . '\' />',
        )));
        isLike('#<meta name=[\'\"]somemeta2[\'\"] content=[\'\"]' . $value . '[\'\"]#ius', $html);
    }

    public function testJSFile()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-jsfile' => $uniq));
        isContain($uniq, $html);
    }

    public function testCSSFile()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-cssfile' => $uniq));
        isContain($uniq, $html);
    }

    public function testJSCode()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-jscode' => $uniq));
        isContain($uniq, $html);
    }

    public function testCSSCode()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-header-csscode' => $uniq));
        isContain($uniq, $html);
    }
}
