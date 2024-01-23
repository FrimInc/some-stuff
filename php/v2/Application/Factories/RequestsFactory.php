<?php

use NW\WebService\References\Operations\Notification\DataDifferences;
use NW\WebService\References\Operations\Notification\OperationRequest\TsReturnOperationData;

class RequestsFactory
{

    public static function arrayToTsReturnOperationData(?array $data): TsReturnOperationData
    {
        $operationData = (new TsReturnOperationData());

        if (empty($data)) {
            return $operationData;
        }

        return $operationData
            ->setResellerId((int)$data['resellerId'])
            ->setNotificationType((int)$data['notificationType'])
            ->setComplaintId((int)$data['complaintNumber'])
            ->setComplaintNumber((string)$data['complaintNumber'])
            ->setClientId((int)$data['clientId'])
            ->setCreatorId((int)$data['creatorId'])
            ->setExpertId((int)$data['expertId'])
            ->setConsumptionId((int)$data['consumptionId'])

            ->setConsumptionNumber((string)$data['consumptionNumber'])
            ->setAgreementNumber((string)$data['agreementNumber'])
            ->setDate((string)$data['date'])

            ->setDifferences(self::arrayToDataDifferences($data['differences']));

    }

    public static function arrayToDataDifferences(?array $data = []): ?DataDifferences
    {
        return (!empty($data) && $data['from'] && $data['to'])
            ? new DataDifferences($data['from'], $data['to'])
            : null;
    }
}
