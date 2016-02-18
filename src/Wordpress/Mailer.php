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
        $headers     = $this->_prepareHeaders();
        $attachments = $this->_prepareAttachments();

        $result = wp_mail($this->_recipient[0], $this->_subject, $this->_body, $headers, $attachments);

        return $result;
    }

    /**
     * Convert headers array to Wordpress format
     *
     * @return array
     */
    protected function _prepareHeaders()
    {
        $headers = $this->_headers;

        if ($this->_htmlMode) {
            $headers['Content-Type'] = 'text/html; charset=UTF-8';
        }

        if (count($this->_from) == 2) {
            if ($this->_from[1]) {
                $headers['From'] = $this->_from[1] . ' <' . $this->_from[0] . '>';
            } else {
                $headers['From'] = $this->_from[0] . ' <' . $this->_from[0] . '>';
            }
        }

        $result = array();
        foreach ($headers as $headerKey => $headerValue) {
            $result[] = sprintf('%1$s: %2$s', $headerKey, $headerValue);
        }

        return $result;
    }

    /**
     * Convert attachments array to Wordpress format
     *
     * @return array
     */
    protected function _prepareAttachments()
    {
        $attachments = array_keys($this->_atachments);

        return $attachments;
    }
}
