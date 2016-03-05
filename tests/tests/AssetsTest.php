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
 * Class AssetsTest
 * @package JBZoo\PHPUnit
 */
class AssetsTest extends CrossCMS
{

    public function testJSFile()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-assets-jsfile' => $uniq));
        isContain($uniq, $html);
    }

    public function testJSCode()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-assets-jscode' => $uniq));
        isContain($uniq, $html);
    }

    public function testCSSFile()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-assets-cssfile' => $uniq));
        isContain($uniq, $html);
    }

    public function testCSSCode()
    {
        $uniq = uniqid('', true);
        $html = Helper::runIsolatedCMS(__METHOD__, array('test-assets-csscode' => $uniq));
        isContain($uniq, $html);
    }
}
