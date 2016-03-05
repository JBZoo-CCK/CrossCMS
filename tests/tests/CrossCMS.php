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
use JBZoo\PimpleDumper\PimpleDumper;

/**
 * Class AssetsTest
 * @package JBZoo\PHPUnit
 */
abstract class CrossCMS extends PHPUnit
{
    /**
     * @var Cms
     */
    protected $_cms;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_cms = Cms::getInstance();

        $dumper = new PimpleDumper();
        $this->_cms->register($dumper);
    }
}
