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

use JBZoo\CrossCMS\Cms;

/**
 * Class AssetsTest
 * @package JBZoo\PHPUnit
 */
class AssetsTest extends PHPUnit
{

    public function testJSFile()
    {
        $uniq = uniqid('', true);
        $html = $this->_runIsolationCMS(__METHOD__, array('test-assets-jsfile' => $uniq));
        isContain($uniq, $html);
    }

    public function testJSCode()
    {
        $uniq = uniqid('', true);
        $html = $this->_runIsolationCMS(__METHOD__, array('test-assets-jscode' => $uniq));
        isContain($uniq, $html);
    }

    public function testCSSFile()
    {
        $uniq = uniqid('', true);
        $html = $this->_runIsolationCMS(__METHOD__, array('test-assets-cssfile' => $uniq));
        isContain($uniq, $html);
    }

    public function testCSSCode()
    {
        $uniq = uniqid('', true);
        $html = $this->_runIsolationCMS(__METHOD__, array('test-assets-csscode' => $uniq));
        isContain($uniq, $html);
    }

    /**
     * @param string $testName
     * @param array  $request
     * @return string
     */
    protected function _runIsolationCMS($testName, $request)
    {
        $testName = str_replace(__NAMESPACE__, '', $testName);
        $testName = preg_replace('#[^a-z0-9]#iu', '-', $testName);
        $testName = preg_replace('#--#iu', '-', $testName);
        $testName = trim($testName, '-');
        $testName = strtolower($testName);

        $cmsType = strtolower(Cms::_('type'));

        $html = cmd('php ./tests/bin/browser.php tests/tests/BrowserEmulatorTest.php', array(
            'configuration'   => 'phpunit-' . $cmsType . '-browser.xml.dist',
            'coverage-clover' => 'build/clover/' . $cmsType . '-' . $testName . '.xml',
            //'coverage-html'   => PROJECT_ROOT . '/build/web/' . $cmsType . '-' . $testName . '/html',
            'jbzoo-env'       => $this->_query($request),
            'stderr'          => '', // Hack for CMS session starting
        ), PROJECT_ROOT, 0);

        return $html;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function _query(array $data = array())
    {
        $data['jbzoo-phpunit'] = 1;

        return http_build_query($data, null, '&');
    }
}
