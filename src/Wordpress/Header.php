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

namespace JBZoo\CrossCMS\Wordpress;

use JBZoo\CrossCMS\AbstractHeader;

/**
 * Class Header
 * @package JBZoo\CrossCMS
 */
class Header extends AbstractHeader
{
    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        add_filter('pre_get_document_title', function () use ($title) {
            return $title;
        }, 9999);
    }

    /**
     * {@inheritdoc}
     */
    public function setDesc($description)
    {
        $this->addMeta('description', $description);
    }

    /**
     * {@inheritdoc}
     */
    public function setKeywords($keywords)
    {
        $this->addMeta('keywords', $keywords);
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($meta, $value = null)
    {
        add_action('wp_head', function () use ($meta, $value) {
            if (null === $value) {
                echo $meta . PHP_EOL;
            } else {
                echo '<meta name="' . $meta . '" content="' . $value . '" />' . PHP_EOL;
            }
        }, 9999);
    }

    /**
     * {@inheritdoc}
     */
    public function noindex()
    {
        $this->addMeta('robots', 'noindex, nofollow');
        $this->_cms['response']->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    /**
     * {@inheritdoc}
     */
    public function jsFile($file)
    {
        $handle = 'crosscms-js-' . md5($file);
        \wp_enqueue_script($handle, $file);
    }

    /**
     * {@inheritdoc}
     */
    public function cssFile($file)
    {
        $handle = 'crosscms-css-' . md5($file);
        \wp_enqueue_style($handle, $file);
    }

    /**
     * {@inheritdoc}
     */
    public function jsCode($code)
    {
        echo '<script type="text/javascript">' . PHP_EOL . $code . PHP_EOL . '</script>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function cssCode($code)
    {
        echo '<style type="text/css">' . $code . '</style>' . PHP_EOL;
    }
}
