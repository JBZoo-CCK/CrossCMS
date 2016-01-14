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

namespace JBZoo\CrossCMS\Joomla;

use JBZoo\CrossCMS\AbstractMailer;

/**
 * Class Mailer
 * @package JBZoo\CrossCMS
 */
class Mailer extends AbstractMailer
{
    /**
     * {@inheritdoc}
     */
    protected function _send()
    {
        $mailer = \JFactory::getMailer();

        if (count($this->_recipient) == 2) {
            $mailer->addRecipient($this->_recipient[0], $this->_recipient[1]);
        }

        if (count($this->_from) == 2) {
            $mailer->setFrom($this->_from[0], $this->_from[1]);
        }

        $mailer->isHtml($this->_htmlMode);
        $mailer->setBody($this->_body);
        $mailer->setSubject($this->_subject);

        foreach ($this->_atachments as $path => $name) {
            $mailer->addAttachment($path, $name);
        }

        foreach ($this->_headers as $headerKey => $headerValue) {
            $mailer->addCustomHeader($headerKey, $headerValue);
        }

        $result = $mailer->send();

        if ($mailer->isError() || !$result) {

            if ($mailer->ErrorInfo) {
                $this->_error($mailer->ErrorInfo);
            }

            return false;
        }

        return $result;
    }
}
