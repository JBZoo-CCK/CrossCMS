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

namespace JBZoo\CrossCMS;

use JBZoo\SqlBuilder\SqlBuilder;
use Pimple\Container;

/**
 * Class CrossCMS
 * @package JBZoo\CrossCMS
 */
class Cms extends Container
{
    /**
     * @var array
     */
    protected $_systemList = array(
        'Joomla',
        'Wordpress',
    );

    /**
     * @return Cms
     */
    public static function getInstance()
    {
        static $instance;

        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Constructor
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct(array());

        $this['global.cms']       = $this->_getCmsType();
        $this['global.namespace'] = __NAMESPACE__ . '\\' . $this['global.cms'] . '\\';

        $this['session'] = function ($cont) {
            $className = $cont['global.namespace'] . 'Session';
            return new $className();
        };


        $this['config.cms'] = function ($cont) {
            $className = $cont['global.namespace'] . 'Config';
            return new $className();
        };


        $this['db'] = function ($cont) {
            $className = $cont['global.namespace'] . 'Database';

            // init SQLBuilder Configuration
            SqlBuilder::set($cont['global.cms']);

            /** @var AbstractDatabase $database */
            $database = new $className();

            return $database;
        };
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function _getCMSType()
    {
        $cmsType = '';

        foreach ($this->_systemList as $system) {
            $mainClass = __NAMESPACE__ . '\\' . $system . '\\' . $system;

            if (class_exists($mainClass) && call_user_func(array($mainClass, 'check'))) {
                $cmsType = $system;
            }
        }

        if (!$cmsType) {
            throw new Exception('Undefined CMS system');
        }

        return $cmsType;
    }

    /**
     * @param $helper
     * @return mixed
     */
    public static function get($helper)
    {
        $cms = self::getInstance();
        return $cms[$helper];
    }
}
