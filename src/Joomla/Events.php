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

namespace JBZoo\CrossCMS\Joomla;

use JBZoo\CrossCMS\AbstractEvents;

/**
 * Class Event
 * @package JBZoo\CrossCMS
 */
class Events extends AbstractEvents
{
    /**
     *  Example of Joomla Plugin (system)
     *
     *  use JBZoo\CrossCMS\Cms;
     *  use JBZoo\CrossCMS\AbstractEvent;
     *
     *  class PlgSystemJBZoo extends JPlugin
     *  {
     *      // $var Cms
     *      protected $this->_app;
     *
     *      // Init
     *      public function onAfterInitialise()
     *      {
     *          require_once './vendor/autoload.php';
     *
     *          $this->_app = Cms::getInstance();
     *
     *          $this->_app->trigger(AbstractEvent::EVENT_INIT);
     *      }
     *
     *      // Header render
     *      public function onBeforeCompileHead()
     *      {
     *          $this->_app->trigger(AbstractEvent::EVENT_HEADER);
     *      }
     *
     *      // Content handlers (for macroses)
     *      public function onAfterRespond()
     *      {
     *          $body = JFactory::getApplication()->getBody();
     *          $this->_app->trigger(AbstractEvent::EVENT_CONTENT, [$body]);
     *          JFactory::getApplication()->setBody($body);
     *
     *          $this->_app->trigger(AbstractEvent::EVENT_SHUTDOWN, [&$body]);
     *      }
     *  }
     */

    /**
     * {@inheritdoc}
     */
    public function filterContent(&$content = null)
    {
        $body = \JFactory::getApplication()->getBody();

        $this->_cms->trigger(AbstractEvents::EVENT_CONTENT, array(&$body));

        \JFactory::getApplication()->setBody($body);
    }
}
