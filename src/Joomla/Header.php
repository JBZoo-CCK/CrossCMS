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
    private $_document = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(Cms $cms)
    {
        parent::__construct($cms);
        $this->_document = \JFactory::getDocument();
    }

    /**
     * {@inheritdoc}
     */
    public function cssFile($file)
    {
        $this->_document->addStyleSheet($file);
    }

    /**
     * {@inheritdoc}
     */
    public function jsFile($file)
    {
        $this->_document->addScript($file);
    }

    /**
     * {@inheritdoc}
     */
    public function cssCode($code)
    {
        $this->_document->addStyleDeclaration($code);
    }

    /**
     * {@inheritdoc}
     */
    public function jsCode($code)
    {
        $this->_document->addScriptDeclaration($code);
    }
}