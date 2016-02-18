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

use JBZoo\CrossCMS\Exception\MailerException;
use JBZoo\Utils\Filter;
use JBZoo\Utils\FS;
use JBZoo\Utils\Arr;

/**
 * Class AbstractMailer
 * @package JBZoo\CrossCMS
 */
abstract class AbstractMailer
{
    const VALIDATE_ALL         = 0;
    const VALIDATE_NO_CHECK    = 1;
    const VALIDATE_NO_EXEPTION = 2;

    /**
     * @var array
     */
    protected $_recipient;

    /**
     * @var array
     */
    protected $_from;

    /**
     * @var string
     */
    protected $_subject;

    /**
     * @var string
     */
    protected $_body;

    /**
     * @var bool
     */
    protected $_htmlMode;

    /**
     * @var array
     */
    protected $_headers;

    /**
     * @var array
     */
    protected $_atachments;

    /**
     * @var int
     */
    protected $_validateMode;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clean();
    }

    /**
     * Clean mailer state
     * @return $this
     */
    public function clean()
    {
        $this->_htmlMode = true;
        $this->_subject  = '';
        $this->_body     = '';

        $this->_recipient  = array();
        $this->_from       = array();
        $this->_headers    = array();
        $this->_atachments = array();

        $this->_validateMode = self::VALIDATE_ALL;

        return $this;
    }

    /**
     * @param string $email
     * @param string $name
     * @return bool
     */
    public function setTo($email, $name = null)
    {
        $this->_recipient = array();

        if ($email = Filter::email($email)) {
            $this->_recipient[0] = $email;
            $this->_recipient[1] = $name;
            return true;
        }

        return false;
    }

    /**
     * @param string $email
     * @param string $name
     * @return bool
     */
    public function setFrom($email, $name = null)
    {
        $this->_from = array();

        if ($email = Filter::email($email)) {
            $this->_from[0] = $email;
            $this->_from[1] = $name;
            return true;
        }

        return false;
    }

    /**
     * @param string $subject
     * @return bool
     */
    public function setSubject($subject)
    {
        $this->_subject = trim($subject);

        return $this->_subject ? true : false;
    }

    /**
     * @param string $body
     * @return bool
     */
    public function setBody($body)
    {
        $this->_body = trim($body);

        return $this->_body ? true : false;
    }

    /**
     * @param bool $isHtml
     */
    public function isHtml($isHtml)
    {
        $this->_htmlMode = (bool)$isHtml;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->setHeader($key, $value);
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function setHeader($key, $value)
    {
        $key   = trim($key);
        $value = trim($value);

        if ($key && $value) {
            $this->_headers[$key] = $value;
            return true;
        }

        return false;
    }

    /**
     * @param array $attachments
     */
    public function addAttachments($attachments)
    {
        foreach ($attachments as $file => $name) {
            $this->addAttachment($file, $name);
        }
    }

    /**
     * @param string $file
     * @param string $name
     * @return bool
     */
    public function addAttachment($file, $name = null)
    {
        if ($file = FS::real($file)) {

            if (!$name) {
                $name = FS::base($file);
            }

            $this->_atachments[$file] = $name;

            return true;
        }

        return false;
    }

    /**
     * Send message via one call
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $from
     * @param array  $attachments
     * @return bool
     *
     * @throws MailerException
     */
    public function complex($to, $subject, $message, $from = null, $attachments = array())
    {
        $this->clean();

        $this->setTo($to);
        $this->setSubject($subject);
        $this->setBody($message);
        $this->setFrom($from);
        $this->addAttachments($attachments);

        $result = $this->send();

        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function send()
    {
        // Simple cleanup
        $this->_headers    = Arr::clean($this->_headers);
        $this->_atachments = Arr::clean($this->_atachments);

        if ($this->_validateMode !== self::VALIDATE_NO_CHECK) {
            if (!$this->_subject) {
                $this->_error('Subject is empty');
            }

            if (!$this->_body) {
                $this->_error('Body is empty');
            }

            if (count($this->_recipient) !== 2) {
                $this->_error('Recipient is empty');
            }
        }

        $result = false;

        try {
            if ($result = $this->_send()) {
                $this->clean();
            }

        } catch (\Exception $e) {
            $this->_error($e->getMessage());

        }

        return $result;
    }

    /**
     * @param int $mode
     */
    public function setValidateMode($mode)
    {
        $this->_validateMode = (int)$mode;
    }

    /**
     * @param $message
     * @throws MailerException
     */
    protected function _error($message)
    {
        if (self::VALIDATE_NO_EXEPTION !== $this->_validateMode) {
            throw new MailerException('CrossCMS Mailer: ' . $message);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    abstract protected function _send();
}
