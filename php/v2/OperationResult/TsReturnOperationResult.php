<?php

namespace NW\WebService\References\Operations\Notification;

use NW\WebService\References\Operations\Notification\OperationResult\OperationResultInterface;

class TsReturnOperationResult implements OperationResultInterface
{

    private bool $notificationEmployeeByEmail;
    private bool $notificationClientByEmail;
    private NotificationClientBySms $notificationClientBySms;

    /**
     * @param bool $notificationEmployeeByEmail
     * @param bool $notificationClientByEmail
     * @param NotificationClientBySms|null $notificationClientBySms
     */
    public function __construct(
        bool $notificationEmployeeByEmail = false,
        bool $notificationClientByEmail = false,
        ?NotificationClientBySms $notificationClientBySms = null
    )
    {
        $this->notificationEmployeeByEmail = $notificationEmployeeByEmail;
        $this->notificationClientByEmail = $notificationClientByEmail;
        $this->notificationClientBySms = $notificationClientBySms ?? new NotificationClientBySms();
    }

    /**
     * @return bool
     */
    public function isNotificationEmployeeByEmail(): bool
    {
        return $this->notificationEmployeeByEmail;
    }

    /**
     * @param bool $notificationEmployeeByEmail
     * @return TsReturnOperationResult
     */
    public function setNotificationEmployeeByEmail(bool $notificationEmployeeByEmail): TsReturnOperationResult
    {
        $this->notificationEmployeeByEmail = $notificationEmployeeByEmail;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNotificationClientByEmail(): bool
    {
        return $this->notificationClientByEmail;
    }

    /**
     * @param bool $notificationClientByEmail
     * @return TsReturnOperationResult
     */
    public function setNotificationClientByEmail(bool $notificationClientByEmail): TsReturnOperationResult
    {
        $this->notificationClientByEmail = $notificationClientByEmail;
        return $this;
    }

    /**
     * @return NotificationClientBySms
     */
    public function getNotificationClientBySms(): NotificationClientBySms
    {
        return $this->notificationClientBySms;
    }

    /**
     * @param NotificationClientBySms $notificationClientBySms
     * @return TsReturnOperationResult
     */
    public function setNotificationClientBySms(NotificationClientBySms $notificationClientBySms): TsReturnOperationResult
    {
        $this->notificationClientBySms = $notificationClientBySms;
        return $this;
    }
}
