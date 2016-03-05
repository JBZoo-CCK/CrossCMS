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
     *
     *  use JBZoo\CrossCMS\Cms;
     *  use JBZoo\CrossCMS\AbstractEvent;
     *
     *  class PlgSystemJBZoo extends JPlugin
     *  {
     *      // Init
     *      public function onAfterInitialise()
     *      {
     *          if (!class_exists('\JBZoo\CrossCMS\Cms')) {
     *              if ($autoloadPath = realpath('./vendor/autoload.php')) {
     *                  require_once $autoloadPath;
     *              }
     *          }
     *
     *          $cms = Cms::getInstance();
     *          $cms['events']->trigger(AbstractEvent::EVENT_INIT);
     *      }
     *
     *      // Header render
     *      public function onBeforeCompileHead()
     *      {
     *          $cms = Cms::getInstance();
     *          $cms['events']->trigger(AbstractEvent::EVENT_HEADER);
     *      }
     *
     *      // Content handlers (for macroses)
     *      public function onAfterRespond()
     *      {
     *          $cms = Cms::getInstance();
     *          $cms['events']->triggerContent();
     *          $cms['events']->trigger(AbstractEvent::EVENT_SHUTDOWN);
     *      }
     *  }
     */

    /**
     * {@inheritdoc}
     */
    public function filterContent(&$content = null)
    {
        $body = \JFactory::getApplication()->getBody();

        $this->trigger(AbstractEvents::EVENT_CONTENT, array(&$body));

        \JFactory::getApplication()->setBody($body);
    }
}
