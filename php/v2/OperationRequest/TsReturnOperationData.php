<?php

namespace NW\WebService\References\Operations\Notification\OperationRequest;

use http\Client;
use NW\WebService\References\Operations\Notification\Contractor;
use NW\WebService\References\Operations\Notification\DataDifferences;
use NW\WebService\References\Operations\Notification\Employee;

class TsReturnOperationData {

    private int $resellerId;
    private int $notificationType;
    private int $complaintId;
    private string $complaintNumber;
    private int $clientId;
    private int $creatorId;
    private int $expertId;
    private int $consumptionId;
    private string $consumptionNumber;
    private string $agreementNumber;
    private string $date;

    private ?DataDifferences $differences;


    private Contractor $client;
    private Employee $creator;
    private Employee $employee;
    /**
     * @return int
     */
    public function getResellerId(): int
    {
        return $this->resellerId;
    }

    /**
     * @param int $resellerId
     * @return TsReturnOperationData
     */
    public function setResellerId(int $resellerId): TsReturnOperationData
    {
        $this->resellerId = $resellerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getNotificationType(): int
    {
        return $this->notificationType;
    }

    /**
     * @param int $notificationType
     * @return TsReturnOperationData
     */
    public function setNotificationType(int $notificationType): TsReturnOperationData
    {
        $this->notificationType = $notificationType;
        return $this;
    }

    /**
     * @return int
     */
    public function getComplaintId(): int
    {
        return $this->complaintId;
    }

    /**
     * @param int $complaintId
     * @return TsReturnOperationData
     */
    public function setComplaintId(int $complaintId): TsReturnOperationData
    {
        $this->complaintId = $complaintId;
        return $this;
    }

    /**
     * @return string
     */
    public function getComplaintNumber(): string
    {
        return $this->complaintNumber;
    }

    /**
     * @param string $complaintNumber
     * @return TsReturnOperationData
     */
    public function setComplaintNumber(string $complaintNumber): TsReturnOperationData
    {
        $this->complaintNumber = $complaintNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     * @return TsReturnOperationData
     */
    public function setClientId(int $clientId): TsReturnOperationData
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    /**
     * @param int $creatorId
     * @return TsReturnOperationData
     */
    public function setCreatorId(int $creatorId): TsReturnOperationData
    {
        $this->creatorId = $creatorId;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpertId(): int
    {
        return $this->expertId;
    }

    /**
     * @param int $expertId
     * @return TsReturnOperationData
     */
    public function setExpertId(int $expertId): TsReturnOperationData
    {
        $this->expertId = $expertId;
        return $this;
    }

    /**
     * @return int
     */
    public function getConsumptionId(): int
    {
        return $this->consumptionId;
    }

    /**
     * @param int $consumptionId
     * @return TsReturnOperationData
     */
    public function setConsumptionId(int $consumptionId): TsReturnOperationData
    {
        $this->consumptionId = $consumptionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getConsumptionNumber(): string
    {
        return $this->consumptionNumber;
    }

    /**
     * @param string $consumptionNumber
     * @return TsReturnOperationData
     */
    public function setConsumptionNumber(string $consumptionNumber): TsReturnOperationData
    {
        $this->consumptionNumber = $consumptionNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgreementNumber(): string
    {
        return $this->agreementNumber;
    }

    /**
     * @param string $agreementNumber
     * @return TsReturnOperationData
     */
    public function setAgreementNumber(string $agreementNumber): TsReturnOperationData
    {
        $this->agreementNumber = $agreementNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return TsReturnOperationData
     */
    public function setDate(string $date): TsReturnOperationData
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return DataDifferences|null
     */
    public function getDifferences(): ?DataDifferences
    {
        return $this->differences;
    }

    /**
     * @param DataDifferences|null $differences
     * @return TsReturnOperationData
     */
    public function setDifferences(?DataDifferences $differences): TsReturnOperationData
    {
        $this->differences = $differences;
        return $this;
    }

    /**
     * @return Contractor
     */
    public function getClient(): Contractor
    {
        return $this->client;
    }

    /**
     * @param Contractor $client
     * @return TsReturnOperationData
     */
    public function setClient(Contractor $client): TsReturnOperationData
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Employee
     */
    public function getCreator(): Employee
    {
        return $this->creator;
    }

    /**
     * @param Employee $creator
     * @return TsReturnOperationData
     */
    public function setCreator(Employee $creator): TsReturnOperationData
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     * @return TsReturnOperationData
     */
    public function setEmployee(Employee $employee): TsReturnOperationData
    {
        $this->employee = $employee;
        return $this;
    }
}