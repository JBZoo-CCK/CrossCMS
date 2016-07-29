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
class HeaderTest extends CrossCMSUnit
{
    public function testTitle()
    {
        $uniq = uniqid();
        $result = $this->helper->request(__METHOD__, array('test-header-title' => $uniq));

        isSame(200, $result->code);
        isContain('<title>' . $uniq . '</title>', $result->body);
    }

    public function testKeywords()
    {
        $uniq = uniqid();
        $result = $this->helper->request(__METHOD__, array('test-header-keywords' => $uniq));

        isSame(200, $result->code);
        isLike('#<meta name=[\'\"]keywords[\'\"] content=[\'\"]' . $uniq . '[\'\"]#ius', $result->body);
    }

    public function testDescription()
    {
        $uniq = uniqid();
        $result = $this->helper->request(__METHOD__, array('test-header-description' => $uniq));

        isSame(200, $result->code);
        isLike('#<meta name=[\'\"]description[\'\"] content=[\'\"]' . $uniq . '[\'\"]#ius', $result->body);
    }

    public function testNoindex()
    {
        $result = $this->helper->request(__METHOD__, array('test-header-noindex' => 1));

        isSame(200, $result->code);
        isSame('noindex, nofollow', $result->find('headers.x-robots-tag'));
        isContain('content="noindex, nofollow"', $result->body);
    }

    public function testAddMeta()
    {
        $value = uniqid();
        $result  = $this->helper->request(__METHOD__, array('test-header-addmeta' => array(
            'meta'  => 'somemeta1',
            'value' => $value,
        )));
        isSame(200, $result->code);
        isLike('#<meta name=[\'\"]somemeta1[\'\"] content=[\'\"]' . $value . '[\'\"]#ius', $result->body);

        $value = uniqid();
        $result  = $this->helper->request(__METHOD__, array('test-header-addmeta' => array(
            'meta' => '<meta name=\'somemeta2\' content=\'' . $value . '\' />',
        )));
        isSame(200, $result->code);
        isLike('#<meta name=[\'\"]somemeta2[\'\"] content=[\'\"]' . $value . '[\'\"]#ius', $result->body);
    }

    public function testJSFile()
    {
        $uniq = uniqid('', true);
        $result = $this->helper->request(__METHOD__, array('test-header-jsfile' => $uniq));
        isSame(200, $result->code);
        isContain($uniq, $result->body);
    }

    public function testCSSFile()
    {
        $uniq = uniqid('', true);
        $result = $this->helper->request(__METHOD__, array('test-header-cssfile' => $uniq));
        isSame(200, $result->code);
        isContain($uniq, $result->body);
    }

    public function testJSCode()
    {
        $uniq = uniqid('', true);
        $result = $this->helper->request(__METHOD__, array('test-header-jscode' => $uniq));
        isSame(200, $result->code);
        isContain($uniq, $result->body);
    }

    public function testCSSCode()
    {
        $uniq = uniqid('', true);
        $result = $this->helper->request(__METHOD__, array('test-header-csscode' => $uniq));
        isSame(200, $result->code);
        isContain($uniq, $result->body);
    }
}
