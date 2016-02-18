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

use JBZoo\CrossCMS\Cms;

/**
 * Class Helper
 * @package JBZoo\PHPUnit
 */
class Helper
{
    /**
     * @param string $testName
     * @param array  $request
     * @return string
     */
    public static function runIsolatedCMS($testName, $request)
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
            'jbzoo-env'       => self::query($request),
            'stderr'          => '', // Hack for CMS session starting
        ), PROJECT_ROOT, (int)getenv('PHPUNIT_CMD_DEBUG'));

        return $html;
    }

    /**
     * @param array $data
     * @return string
     */
    public static function query(array $data = array())
    {
        $data['jbzoo-phpunit'] = 1;

        return http_build_query($data, null, '&');
    }
}