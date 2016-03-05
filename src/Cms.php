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

namespace JBZoo\CrossCMS;

use JBZoo\CrossCMS\Exception\Exception;
use JBZoo\Event\EventManager;
use JBZoo\Lang\Lang;
use JBZoo\Path\Path;
use JBZoo\SqlBuilder\SqlBuilder;
use Pimple\Container;

/**
 * Class CrossCMS
 * @package JBZoo\CrossCMS
 */
class Cms extends Container
{
    const TYPE_JOOMLA    = 'Joomla';
    const TYPE_WORDPRESS = 'Wordpress';

    /**
     * @var array
     */
    protected $_systemList = array(
        self::TYPE_JOOMLA,
        self::TYPE_WORDPRESS,
    );

    /**
     * @param string $helper
     * @return mixed
     */
    public static function _($helper)
    {
        $cms = self::getInstance();
        return $cms[$helper];
    }

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

        $this['type'] = $this->_getCmsType();
        $this['ns']   = __NAMESPACE__ . '\\' . $this['type'] . '\\';

        $this['db'] = function ($cms) {
            SqlBuilder::set($cms['type']); // init SQLBuilder Driver
            $className = $cms['ns'] . 'Database';
            $database  = new $className();
            return $database;
        };

        $this['path'] = function ($cms) {
            $className = $cms['ns'] . 'Path';

            /** @var AbstractPath $helper */
            $helper = new $className();
            $path   = Path::getInstance('crosscms');

            $path->setRoot($helper->getRoot());
            $path->add($helper->getRoot(), 'root');
            $path->add($helper->getUpload(), 'upload');
            $path->add($helper->getCache(), 'cache');
            $path->add($helper->getTmpl(), 'tmpl');
            $path->add($helper->getLogs(), 'logs');
            $path->add($helper->getTmp(), 'tmp');
            $path->add(__DIR__ . '/../src', 'crosscms');

            return $path;
        };

        $this['events'] = function ($cms) {
            $eventManager = new EventManager();
            $className    = $cms['ns'] . 'Events';
            $helper       = new $className($eventManager);
            return $helper;
        };

        $this['lang'] = function ($cms) {
            $className = $cms['ns'] . 'Lang';
            $helper    = new $className();

            $lang = new Lang($helper->getCode());
            $helper->setCustomLang($lang);

            return $helper;
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
     * @param string $id
     * @return mixed
     */
    public function offsetGet($id)
    {
        $id = strtolower($id);

        if (!isset($this[$id])) {
            $this[$id] = function ($cms) use ($id) {
                $className = $cms['ns'] . ucfirst($id);
                $helper    = new $className();
                return $helper;
            };
        }

        return parent::offsetGet($id);
    }
}
