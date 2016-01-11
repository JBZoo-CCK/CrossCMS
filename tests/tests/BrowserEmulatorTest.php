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
 * Class BrowserEmulatorTest
 * @package JBZoo\PHPUnit
 */
class BrowserEmulatorTest extends PHPUnit
{
    /**
     * @group browser
     */
    public function test()
    {
        require_once './tests/autoload/browser-emulate.php';
        require_once './tests/autoload/browser-cms-init.php';

        isTrue(true); // phpunit hack
    }
}
