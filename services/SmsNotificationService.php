<?php

declare(strict_types=1);

namespace app\services;

use app\components\SmsSenderInterface;
use Yii;

class SmsNotificationService implements NotificationServiceInterface
{
    private SmsSenderInterface $smsSender;

    public function __construct(SmsSenderInterface $smsSender)
    {
        $this->smsSender = $smsSender;
    }

    public function sendSms(string $phone, string $message): bool
    {
        try {
            return $this->smsSender->send($phone, $message);
        } catch (\Exception $e) {
            Yii::error('Failed to send SMS: ' . $e->getMessage(), __METHOD__);
            return false;
        }
    }
}

