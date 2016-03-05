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
 * Class CacheTest
 * @package JBZoo\PHPUnit
 */
class CacheTest extends CrossCMS
{
    public function testEnabled()
    {
        $cache = $this->_cms['cache'];

        //isTrue($cache->isEnabled());
        $cache->isEnabled();
    }

    public function testVariableCache()
    {
        $cache = $this->_cms['cache'];

        $someVar = array(
            'true' => true,
            'some' => 'qwerty',
            'arr'  => array(1, 2, 3),
            'obj'  => (object)array('q' => 1, 'w' => 2, 'e' => 3),
        );

        $cache->set('some-var', $someVar, 'default', true);
        is($cache->get('some-var'), $someVar);
    }

    public function testOutputCache()
    {
        $cache = $this->_cms['cache'];

        $randKey = uniqid('', true);
        $output  = 'output-' . $randKey;
        $keyId   = 'key-' . $randKey;

        // save to cache
        ob_start();
        if (!$cache->start($keyId, 'default', true)) {
            echo $output; // some output
            $cache->end($keyId, 'default');
        }

        $outputBeforeCache = ob_get_contents();
        ob_end_clean();


        // check cached data
        ob_start();
        if (!$cache->start($keyId, 'default', true)) {
            echo 'Some new data'; // cache mut be valid still
            $cache->end($keyId, 'default');
        }
        $outputAfterCache = ob_get_contents();
        ob_end_clean();


        isSame($outputBeforeCache, $outputAfterCache);
    }
}
