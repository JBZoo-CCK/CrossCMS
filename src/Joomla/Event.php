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

use JBZoo\CrossCMS\AbstractEvent;

/**
 * Class Event
 * @package JBZoo\CrossCMS
 */
class Event extends AbstractEvent
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
     *          Cms::_('event')->trigger(AbstractEvent::EVENT_INIT);
     *      }
     *
     *      // Header render
     *      public function onBeforeCompileHead()
     *      {
     *          Cms::_('event')->trigger(AbstractEvent::EVENT_HEADER);
     *      }
     *
     *      // Content handlers (for macroses)
     *      public function onAfterRespond()
     *      {
     *          Cms::_('event')->triggerContent();
     *          Cms::_('event')->trigger(AbstractEvent::EVENT_SHUTDOWN);
     *      }
     *  }
     */

    /**
     * {@inheritdoc}
     */
    public function filterContent(&$content = null)
    {
        $body = \JFactory::getApplication()->getBody();

        $this->trigger(AbstractEvent::EVENT_CONTENT, array(&$body));

        \JFactory::getApplication()->setBody($body);
    }
}
