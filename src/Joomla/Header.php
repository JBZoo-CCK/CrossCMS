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

use JBZoo\CrossCMS\AbstractHeader;
use JBZoo\CrossCMS\Cms;

/**
 * Class Header
 * @package JBZoo\CrossCMS
 */
class Header extends AbstractHeader
{
    /**
     * @var \JDocumentHTML
     */
    private $_doc = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(Cms $cms)
    {
        parent::__construct($cms);
        $this->_doc = \JFactory::getDocument();
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->_doc->setTitle($title);
    }

    /**
     * {@inheritdoc}
     */
    public function setDesc($description)
    {
        $this->_doc->setDescription($description);
        $this->_doc->setMetadata('description', $description);
    }

    /**
     * {@inheritdoc}
     */
    public function setKeywords($keywords)
    {
        $this->_doc->setMetadata('keywords', $keywords);
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($meta, $value = null)
    {
        if (null === $value) {
            $this->_doc->addCustomTag($meta);
        } else {
            $this->_doc->setMetadata($meta, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function noindex()
    {
        $this->_doc->setMetadata('robots', 'noindex, nofollow');
        $this->_cms['response']->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    /**
     * {@inheritdoc}
     */
    public function jsFile($file)
    {
        $this->_doc->addScript($file);
    }

    /**
     * {@inheritdoc}
     */
    public function cssFile($file)
    {
        $this->_doc->addStyleSheet($file);
    }

    /**
     * {@inheritdoc}
     */
    public function jsCode($code)
    {
        $this->_doc->addScriptDeclaration($code);
    }

    /**
     * {@inheritdoc}
     */
    public function cssCode($code)
    {
        $this->_doc->addStyleDeclaration($code);
    }
}
