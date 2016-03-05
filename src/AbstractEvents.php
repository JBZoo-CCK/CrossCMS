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

use JBZoo\Event\EventManager;

/**
 * Class AbstractEvent
 * @package JBZoo\CrossCMS
 */
abstract class AbstractEvents extends AbstractHelper
{
    const POSTFIX_ADMIN = '.admin';
    const POSTFIX_SITE  = '.site';

    const EVENT_INIT     = 'cms.init';
    const EVENT_CONTENT  = 'cms.content';
    const EVENT_HEADER   = 'cms.header';
    const EVENT_SHUTDOWN = 'cms.shutdown';

    /**
     * @var EventManager
     */
    protected $_eManager;

    /**
     * AbstractEvents constructor
     * @param Cms          $cms
     * @param EventManager $eManager
     */
    public function __construct(Cms $cms, EventManager $eManager)
    {
        parent::__construct($cms);
        $this->_eManager = $eManager;
    }

    /**
     * Bind callback on some event
     *
     * @param string   $triggerName
     * @param callable $function
     * @param int      $priority
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function on($triggerName, callable $function, $priority = EventManager::MID)
    {
        $this->_eManager->on($triggerName, $function, $priority);
    }

    /**
     * Excecute trigger
     *
     * @param string $triggerName
     * @param array  $arguments
     * @return int|string
     *
     * @throws \JBZoo\Event\ExceptionStop
     */
    public function trigger($triggerName, array $arguments = array())
    {
        $count = $this->_eManager->trigger($triggerName, $arguments);

        if ($this->_isAdmin()) {
            $count += $this->_eManager->trigger($triggerName . self::POSTFIX_ADMIN, $arguments);
        } else {
            $count += $this->_eManager->trigger($triggerName . self::POSTFIX_SITE, $arguments);
        }

        return $count;
    }

    /**
     * @param string|null $content
     * @return mixed
     */
    abstract public function filterContent(&$content = null);

    /**
     * @return bool
     */
    protected function _isAdmin()
    {
        return $this->_cms['env']->isAdmin();
    }
}
