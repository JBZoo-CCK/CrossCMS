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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractEvent;

/**
 * Class Event
 * @package JBZoo\CrossCMS
 */
class Event extends AbstractEvent
{
    /**
     * Example of Wordpress Plugin with hooks
     *
     *
     *  // Init
     *  add_action('wp', function () {
     *      Cms::_('event')->trigger(AbstractEvent::EVENT_INIT);
     *  });
     *
     *
     *  // Header render
     *  add_action('wp_head', function () {
     *      Cms::_('event')->trigger(AbstractEvent::EVENT_HEADER);
     *  });
     *
     *
     *  // Content handlers (for macroses)
     *  add_filter('the_content', function ($content) {
     *      Cms::_('event')->filterContent($content);
     *      return $content;
     *  });
     */

    /**
     * {@inheritdoc}
     */
    public function filterContent(&$content = null)
    {
        $this->trigger(AbstractEvent::EVENT_CONTENT, array(&$content));
    }
}
