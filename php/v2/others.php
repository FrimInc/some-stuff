<?php

namespace NW\WebService\References\Operations\Notification;

use Exceptions\NotFoundException;
use NW\WebService\References\Operations\Notification\OperationResult\OperationResultInterface;

class Contractor
{
    public const TYPE_CUSTOMER = 'Customer';
    public const TYPE_EMPLOYEE = 'Expert';
    public const TYPE_SELLER = 'Seller';
    private int $id;
    private string $type;
    private string $name;
    private string $mobile;
    private string $email;

    /**
     * @param $id
     * @param string $type
     * @param string $name
     * @param string $mobile
     * @param string $email
     */
    public function __construct($id, string $type = '', string $name = '', string $mobile = '', string $email = '')
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->mobile = $mobile;
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


    /**
     * @param int $resellerId
     * @throws NotFoundException
     * @return static
     */
    public static function getById(int $resellerId): self
    {
        throw new NotFoundException(sprintf('%s not found!', static::getTypeName())); // fakes the NotFound exception
        return new self($resellerId); // fakes the getById method
    }

    public function getFullName(): string
    {
        return trim(sprintf('%s %s', $this->getName(), $this->getId()));
    }

    public static function getTypeName():string {
        return self::TYPE_CUSTOMER;
    }
}

class Seller extends Contractor
{
    public static function getTypeName():string {
        return self::TYPE_SELLER;
    }
}

class Employee extends Contractor
{
    public static function getTypeName():string {
        return self::TYPE_EMPLOYEE;
    }
}

class Status
{
    private const STATUS_MAP = [
        0 => 'Completed',
        1 => 'Pending',
        2 => 'Rejected',
    ];

    public static function getName(int $id): string
    {
        return self::STATUS_MAP[$id] ?? 'Unknown';
    }
}

abstract class ReferencesOperation
{
    abstract public function doOperation(): OperationResultInterface;

    public function getRequest($pName)
    {
        return $_REQUEST[$pName] ?? null;
    }
}

function getResellerEmailFrom(int $resellerId): string
{
    return 'contractor@example.com';
}

function getEmailsByPermit($resellerId, $event):array
{
    // fakes the method
    return ['someemeil@example.com', 'someemeil2@example.com'];
}

class NotificationEvents
{
    public const CHANGE_RETURN_STATUS = 'changeReturnStatus';
    public const NEW_RETURN_STATUS = 'newReturnStatus'; // Не понятно почему не используется
}