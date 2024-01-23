<?php

namespace NW\WebService\References\Operations\Notification;

use Exceptions\NotFoundException;
use Exceptions\TsReturnOperationException;
use NW\WebService\References\Operations\Notification\OperationRequest\TsReturnOperationData;
use RequestsFactory;
use Throwable;

class TsReturnOperation extends ReferencesOperation
{
    public const TYPE_NEW = 1;
    public const TYPE_CHANGE = 2;

    /**
     * @return TsReturnOperationResult
     * @throws TsReturnOperationException
     */
    public function doOperation(): TsReturnOperationResult
    {
        $operationData = RequestsFactory::arrayToTsReturnOperationData($this->getRequest('data'));

        $tsReturnOperationResult = new TsReturnOperationResult();

        if (!$operationData->getResellerId()) {
            // Допустим, что это конкретный кейс, в котором мы возвращаем result
            // @TODO переделать на исключения
            $tsReturnOperationResult->getNotificationClientBySms()->setMessage('Empty resellerId');
            return $tsReturnOperationResult;
        }

        $this->prepareOperationData($operationData);

        $templateData = self::getTemplateData($operationData);
        $emailFrom = getResellerEmailFrom($operationData->getResellerId());

        $tsReturnOperationResult->setNotificationEmployeeByEmail($this->sendEmployeeEmails($operationData, $templateData, $emailFrom));

        // Шлём клиентское уведомление, только если произошла смена статуса
        if ($operationData->getNotificationType() === self::TYPE_CHANGE
            && $operationData->getDifferences() !== null
        ) {
            $tsReturnOperationResult->setNotificationClientByEmail($this->sendClientEmails($operationData, $templateData, $emailFrom));
            try {
                $tsReturnOperationResult->getNotificationClientBySms()
                    ->setSent($this->sendClientSms($operationData, $templateData));
            } catch (Throwable $e) {
                $tsReturnOperationResult->getNotificationClientBySms()->setMessage($e->getMessage());
            }
        }

        return $tsReturnOperationResult;
    }

    /**
     * @throws TsReturnOperationException
     */
    private function prepareOperationData(TsReturnOperationData $operationData): void
    {
        if (!$operationData->getNotificationType()) {
            throw new TsReturnOperationException('Empty notificationType', 400);
        }

        try {
            Seller::getById($operationData->getResellerId());
            $operationData->setClient(Contractor::getById($operationData->getClientId()));
            $operationData->setCreator(Employee::getById($operationData->getCreatorId()));
            $operationData->setEmployee(Employee::getById($operationData->getExpertId()));
        } catch (NotFoundException $e) {
            throw new TsReturnOperationException($e->getMessage(), 400);
        }

        if ($operationData->getClient()->getType() !== Contractor::TYPE_CUSTOMER
            || $operationData->getClient()->getId() !== $operationData->getResellerId()
        ) {
            throw new TsReturnOperationException('Client not found!', 400);
        }
    }

    private static function getDifferences(TsReturnOperationData $operationData): string
    {
        $differences = '';

        if ($operationData->getNotificationType() === self::TYPE_NEW) {
            $differences = __('NewPositionAdded', null, $operationData->getResellerId());
        } elseif ($operationData->getNotificationType() === self::TYPE_CHANGE
            && $operationData->getDifferences() !== null
        ) {
            $differences = __('PositionStatusHasChanged', [
                'FROM' => Status::getName($operationData->getDifferences()->getFrom()),
                'TO' => Status::getName($operationData->getDifferences()->getTo()),
            ], $operationData->getResellerId());
        }

        return $differences;
    }

    /**
     * @throws TsReturnOperationException
     */
    private static function getTemplateData(TsReturnOperationData $operationData): array
    {
        $templateData = [
            'COMPLAINT_ID' => $operationData->getComplaintId(),
            'COMPLAINT_NUMBER' => $operationData->getComplaintNumber(),
            'CREATOR_ID' => $operationData->getCreatorId(),
            'CREATOR_NAME' => $operationData->getCreator()->getFullName(),
            'EXPERT_ID' => $operationData->getExpertId(),
            'EXPERT_NAME' => $operationData->getEmployee()->getFullName(),
            'CLIENT_ID' => $operationData->getClientId(),
            'CLIENT_NAME' => $operationData->getClient()->getFullName(),
            'CONSUMPTION_ID' => $operationData->getConsumptionId(),
            'CONSUMPTION_NUMBER' => $operationData->getConsumptionNumber(),
            'AGREEMENT_NUMBER' => $operationData->getAgreementNumber(),
            'DATE' => $operationData->getDate(),
            'DIFFERENCES' => self::getDifferences($operationData),
        ];

        foreach ($templateData as $key => $tempData) {
            if (empty($tempData)) {
                throw new TsReturnOperationException("Template Data ({$key}) is empty!", 500);
            }
        }

        return $templateData;
    }

    private function sendEmployeeEmails(TsReturnOperationData $operationData, array $templateData, string $emailFrom): bool
    {

        // Получаем email сотрудников из настроек
        $emails = getEmailsByPermit($operationData->getResellerId(), 'tsGoodsReturn');
        $isNotificationEmployeeByEmail = false;
        if (!empty($emailFrom) && count($emails) > 0) {
            foreach ($emails as $email) {
                MessagesClient::sendMessage([
                    0 => [ // MessageTypes::EMAIL
                        'emailFrom' => $emailFrom,
                        'emailTo' => $email,
                        'subject' => __(
                            'complaintEmployeeEmailSubject',
                            $templateData,
                            $operationData->getResellerId()
                        ),
                        'message' => __(
                            'complaintEmployeeEmailBody',
                            $templateData,
                            $operationData->getResellerId()
                        ),
                    ],
                ],
                    $operationData->getResellerId(),
                    NotificationEvents::CHANGE_RETURN_STATUS
                );
                $isNotificationEmployeeByEmail = true;
            }
        }
        return $isNotificationEmployeeByEmail;
    }

    private function sendClientEmails(TsReturnOperationData $operationData, array $templateData, string $emailFrom): bool
    {
        if (!empty($emailFrom) && !empty($operationData->getClient()->getEmail())) {
            MessagesClient::sendMessage([
                0 => [ // MessageTypes::EMAIL
                    'emailFrom' => $emailFrom,
                    'emailTo' => $operationData->getClient()->getEmail(),
                    'subject' => __('complaintClientEmailSubject', $templateData, $operationData->getResellerId()),
                    'message' => __('complaintClientEmailBody', $templateData, $operationData->getResellerId()),
                ],
            ], $operationData->getResellerId(),
                $operationData->getClient()->getId(),
                NotificationEvents::CHANGE_RETURN_STATUS,
                $operationData->getDifferences()->getTo()
            );
            return true;
        }
        return false;
    }

    private function sendClientSms(TsReturnOperationData $operationData, array $templateData): bool
    {
        if (!empty($operationData->getClient()->getMobile())) {
            // @TODO выяснить, какой из параметров должен быть номером мобилки
            return (bool)NotificationManager::send(
                $operationData->getResellerId(),
                $operationData->getClient()->getId(),
                NotificationEvents::CHANGE_RETURN_STATUS,
                $operationData->getDifferences()->getTo(),
                $templateData
            );
        }
        return false;
    }

}
