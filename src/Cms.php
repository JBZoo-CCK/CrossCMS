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
     * @var string
     */
    protected $_system = '';
    protected $_sysPrefix = '';

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

        $this->_prepare();

        $this['session'] = function ($c) {
            $className = $c->_systemPrefix . 'Session';
            return new $className();
        };

        $this['config.cms'] = function ($c) {
            $className = $c->_systemPrefix . 'Config';
            return new $className();
        };

        $this['db'] = function ($c) {
            $className = $c->_systemPrefix . 'Database';

            // init SQLBuilder Configuration
            SqlBuilder::set($c->_system);

            /** @var AbstractDatabase $db */
            $db = new $className();

            return $db;
        };
    }

    /**
     * @throws Exception
     */
    protected function _prepare()
    {
        $this->_system = '';

        foreach ($this->_systemList as $system) {
            $mainClass = __NAMESPACE__ . '\\' . $system . '\\' . $system;

            if (class_exists($mainClass) && call_user_func(array($mainClass, 'check'))) {
                $this->_system = $system;
            }
        }

        if (!$this->_system) {
            throw new Exception('Undefined CMS system');
        }

        $this->_systemPrefix = __NAMESPACE__ . '\\' . $this->_system . '\\';
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
