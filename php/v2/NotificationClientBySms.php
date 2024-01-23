<?php

namespace NW\WebService\References\Operations\Notification;

class NotificationClientBySms
{

    private bool $sent;
    private string $message;

    /**
     * @param bool $sent
     * @param string $message
     */
    public function __construct(bool $sent = false, string $message = '')
    {
        $this->sent = $sent;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isSent(): bool
    {
        return $this->sent;
    }

    /**
     * @param bool $sent
     * @return NotificationClientBySms
     */
    public function setSent(bool $sent): NotificationClientBySms
    {
        $this->sent = $sent;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return NotificationClientBySms
     */
    public function setMessage(string $message): NotificationClientBySms
    {
        $this->message = $message;
        return $this;
    }
}